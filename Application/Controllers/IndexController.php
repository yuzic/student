<?
    class IndexController extends Controller{

        public function actionIndex(){
            $userList = Query::getArray("SELECT * FROM st_user");

            //print_r($sql);
//            while ($fetch  = mysqli_fetch_array($sql )){
//                echo $fetch['email'];
//            }

            $this->view->render('index');
        }

        /**
         * автокоплит поиск
         */
        public function actionSearch(){
            Loader::loadHelper('Charset');
            $search = Helper_Charset::convert(
                                    Request::getPost('str')
                                );

            if (!empty($search)){
                $goodsCollection = Model_Collection_Manager::byQuery('goods_data',
                    Query::instance()
                        ->select('*')
                        ->from('goods_data','goods')
                        ->like('name=?',$search)
                );
                $search = array();
                $limit=0;
                foreach ($goodsCollection as $goods){
                    $search[] = array(  'id'=>$goods['id'],
                        'name'=>strtolower($goods['name']),
                        'descript'=>$goods['descript']);
                    $limit++;
                    if ($limit >=10){
                        break;
                    }

                }
                echo json_encode($search);
            }

        }
    }
