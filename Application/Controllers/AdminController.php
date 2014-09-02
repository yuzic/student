<?php
class AdminController extends Controller{

    public function actionAdd()
    {
        $post = json_decode(Request::getPost('request'), true);
        if (!empty($post['email'])){
            Loader::loadModel('User');
            Loader::loadModel('UserProfile');
            Loader::loadHelper('Html');
            $post = Html::addslash($post);
            // user
            $user = new User([], 'user');
            $user->_data = [
                'email' => addslashes($post['email']),
                'password' => md5($post['password'])
            ];
            $userId =   $user->save();
            $userProfile = new UserProfile([], 'userProfile');
            $userProfile->_data = [
              'firstName' => $post['firstName'],
              'surname' => $post['surname'],
              'groupId' => $post['groupId'],
              'userId' => $userId,
              'dob' => $post['dob'],
              'ip' => ip2long($_SERVER['REMOTE_ADDR']),
            ];

            if ( $userProfile->save())
                 echo json_encode(array('status' => 'ok'));
        }else{
            $this->view->render('create');
        }

    }

    public function actionUserTopRating()
    {
        $sql = "SELECT avg(rating) as ratingAvg,userId
                FROM userRating
                GROUP BY userId limit 10";
        $ratingList  = Query::asQuery($sql);
        Query::asQuery("TRUNCATE TABLE `userRatingAverage`");
        foreach ($ratingList as $data){
            $sql = "INSERT INTO userRatingAverage
                                (userId, ratingAvg)
                    VALUES ('{$data['userId']}',
                            '{$data['ratingAvg']}')";
            Query::asQuery($sql);
        }
        $sqlRating = "SELECT rating.ratingAvg as ratingAvg,
                              profile.firstName as firstName,
                             profile.surname as surname
                      FROM userRatingAverage as rating,
                           userProfile as profile
                      WHERE rating.userId = profile.userId";
        $this->view->listRating  = Query::getArray($sqlRating);
        $this->view->render('listRatingAverage');


    }

    public function actionAddUserRating()
    {
        $id = (int) Request::getPost('userId');
        if ($id)
        {
            $sql = "SELECT * FROM user
                    WHERE id='{$id}'";
            $this->view->user = Query::getRow($sql);
            $this->view->subjectList = Query::getArray("SELECT * FROM userSubject");
            $userRating = Query::getArray("SELECT userRating.rating as rating,
                                                  userSubject.name as name
                                           FROM userRating, userSubject
                                           WHERE userRating.userSubjectId = userSubject.id
                                           AND userId='{$id}'");
            if (count($userRating) ==0)
                 $this->view->render('createRating');
            else{
                $this->view->listRating = $userRating;
                $this->view->render('listRating');
            }

        }else{
            $post = json_decode(Request::getPost('request'), true);
            $userId = (int) $post['userId'];
            $userProfile = Query::getRow("SELECT * FROM userProfile
                                          WHERE userId='{$userId}'");
            Loader::loadModel('UserRating');
            $userRating = new UserRating([], 'userRating');
            $keys = array_keys($post);
            for($i=0; $i < count($keys);$i++){
                $key = $keys[$i];
                if (strpos(' '.$key, 'subject')){
                    $userRating->_data = [
                    'userId' => $userId,
                    'userProfileId' => (int) $userProfile['id'],
                    'userSubjectId' => (int) str_replace('subject_','',$key),
                    'semestrerId' => 1,
                    'teacherId' => 2,
                    'rating' => (int) $post[$key],
                    'schoolyear' => 2014,

                    ];
                    $userRating->save();

                }
            }
            echo json_encode(array('status' => 'ok'));
        }
    }

    public function actionList()
    {
        $sql = "SELECT user.id as userId,
                       user.email as email,
                       profile.firstName as firstName,
                       profile.surname as surname,
                       profile.dob as dob,
                       userGroup.name as groupName
                FROM user,
                     userProfile as profile,
                     userGroup
                WHERE user.id=profile.userId
                AND profile.groupId=userGroup.id
                ORDER BY created DESC";
        $studentList = Query::getArray($sql);
        $this->view->studentList = $studentList;
        $this->view->render('list');
    }

    public function actionDelete()
    {
        Loader::loadModel('User');
        $id = (int) Request::getPost('id');
        $user = new User([], 'user');
        $user->keySet($id);
        if ($user->delete())
            echo json_encode(array('status' => 'ok'));
    }

    public function actionIndex()
    {
        Loader::loadHelper('Html');
        $this->view->render('admin');
    }
}
