# среднее
SELECT avg(CASE WHEN userRating.rating < 5 and userRating.rating > 1 THEN userRating.rating END ) as rating ,
  userProfile.userId,
  userProfile.surname
FROM userRating,userProfile
WHERE userProfile.userId = userRating.userId
AND userProfile.firstName like '%Юрий%'
GROUP BY userId

#более одной регистрации
SELECT `ip` FROM `userProfile` WHERE `ip` in ( SELECT `ip` FROM `userProfile` GROUP BY `ip` HAVING count(*)>1)
