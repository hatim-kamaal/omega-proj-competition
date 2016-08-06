<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$userid=$jsondata->{'userid'};
$champid=$jsondata->{'champid'};
//$MatchPlayed=$jsondata->{'MatchPlayed'};
//$MatchTillFinal=$jsondata->{'MatchTillFinal'};
//$NextOpponent=$jsondata->{'NextOpponent'};
//$UserRank=$jsondata->{'UserRank'};
//$OpponentRank=$jsondata->{'OpponentRank'};
//$PlayRoundUntil=$jsondata->{'PlayRoundUntil'};




//$champid=1;
//$userid=33;
//$ScheduledId='1';
//$MatchPlayed='2';
//$MatchTillFinal ='1';
//$NextOpponent='1';
//$UserRank='33';
//$OpponentRank='1';
//$PlayRoundUntil='2';

if(isset($userid))

{


     $query="select max(Round.Round)AS round From ScheduleRound,Round Where `ChampionshipId`='$champid' and(`UserId`='$userid' or `OpponentId`='$userid') and ScheduleRound.RoundId=Round.RoundId";

     $sqlresult = mysql_query($query);

      $count = mysql_num_rows($sqlresult);


       if ($count > 0) 
       {
          while($data = mysql_fetch_assoc($sqlresult))
         {

                      $Round=$data['round'];
         }
        $sql="select User.user_id from Results,User Where (Results.`OpponentId`=User.user_id or Results.`UserId`=User.user_id) and Results.`Round`='$Round' and Results.`ChampId`='$champid' and (Results.`UserId`='$userid' or Results.`OpponentId`='$userid')";
        $sql1 = mysql_query($sql);

        $count1 = mysql_num_rows($sql1);
       if($count1 > 0)
       {
               while($data1 = mysql_fetch_assoc($sql1))
               {

                      $oppId=$data1['user_id'];
                      if($oppId == $userid)
                      {

                      }
                      else
                      {
                            $oppUserId=$oppId;
                      }
               }
               $qu="select User.username as oppousername,Ranking.Rank as opporank,(select User.username from Ranking,User where Ranking.`userId`=User.user_id and Ranking.`userId`='$userid') as username,(select Ranking.Rank from Ranking,User where Ranking.`userId`=User.user_id and Ranking.`userId`='$userid') as userRank From Ranking,User Where Ranking.`userId`=User.user_id and Ranking.`userId`='$oppUserId'";
              $qu1= mysql_query($qu);
               $count2 = mysql_num_rows($qu1);
               if($count2 > 0)
               {
                      while($data2 = mysql_fetch_assoc($qu1))
                     {

                           $opponame=$data2['oppousername'];
                           $opporank=$data2['opporank'];
                           $username=$data2['username'];
                           $userrank=$data2['userRank'];

                      }

                      $data=array("status"=> 1 ,"msg"=>"Success","opponame" =>$opponame,"opporank"=>$opporank,"MatchPlayed"=>$Round,"username"=>$username,"userrank"=>$userrank); 
               }
               else
               {
                       $data = array("status" => 0, "msg" => "Failure");

               }


       }
       else
       {
           $newQuer="select ScheduleRound.`UserId`,ScheduleRound.`OpponentId` from Round,ScheduleRound Where ScheduleRound.`RoundId`=Round.RoundId and Round.Round='$Round' and ScheduleRound.`ChampionshipId`='$champid' and (ScheduleRound.`UserId`='$userid' or ScheduleRound.`OpponentId`='$userid')";
	    $newsqlRes= mysql_query($newQuer);

            $count3 = mysql_num_rows($newsqlRes);
             if($count3 > 0)
             {
                  while($data9 = mysql_fetch_assoc($newsqlRes))
                   {

                      $uid=$data9['UserId'];
                      $oppid=$data9['OpponentId'];

                      if($uid == $userid)
                      {
                          $newq1= "select User.username as oppousername,Ranking.Rank as opporank,(select User.username from Ranking,User where Ranking.`userId`=User.user_id and Ranking.`userId`='$uid') as username,(select Ranking.Rank from Ranking,User where Ranking.`userId`=User.user_id and Ranking.`userId`='$uid') as userRank From Ranking,User Where Ranking.`userId`=User.user_id and Ranking.`userId`='$oppid'";
                           
                          $qu2= mysql_query($newq1);
                          $count4 = mysql_num_rows($qu2);
                          if($count4 > 0)
                         {
                            while($data4 = mysql_fetch_assoc($qu2))
                           {

                                 $opponame=$data4['oppousername'];
                                 $opporank=$data4['opporank'];
                                 $username=$data4['username'];
                                 $userrank=$data4['userRank'];

                           }

                           $newRound=$Round-1;

                            $data=array("status"=> 1 ,"msg"=>"Success","opponame" =>$opponame,"opporank"=>$opporank,"MatchPlayed"=>$newRound,"username"=>$username,"userrank"=>$userrank); 
                         }
                         else
                         {
                                 $data = array("status" => 0, "msg" => "Failure");

                          }




                      }
                      else
                      {


                              $newq2= "select User.username as oppousername,Ranking.Rank as opporank,(select User.username from Ranking,User where Ranking.`userId`=User.user_id and Ranking.`userId`='$oppid') as username,(select Ranking.Rank from Ranking,User where Ranking.`userId`=User.user_id and Ranking.`userId`='$oppid') as userRank From Ranking,User Where Ranking.`userId`=User.user_id and Ranking.`userId`='$uid'";
                           
                          $qu3= mysql_query($newq2);
                          $count2 = mysql_num_rows($qu1);
                          if($count2 > 0)
                         {
                            while($data3 = mysql_fetch_assoc($qu3))
                           {

                                 $opponame=$data3['oppousername'];
                                 $opporank=$data3['opporank'];
                                 $username=$data3['username'];
                                 $userrank=$data3['userRank'];

                           }

                           $newRound=$Round-1;

                            $data=array("status"=> 1 ,"msg"=>"Success","opponame" =>$opponame,"opporank"=>$opporank,"MatchPlayed"=>$newRound,"username"=>$username,"userrank"=>$userrank); 
                         }
                         else
                         {
                                 $data = array("status" => 0, "msg" => "Failure");

                          }



                      }
               }
            }
            else
            {
                         $data = array("status" => 0, "msg" => "Failure1");
   
            }


       }






      }
      
  else
      {
			$data = array("status" => 0, "msg" => "No Record found");	
			
      }

  }
 
  else
  {
		$data = array("status" => 0, "msg" => " User Id Not Found");	

  }
}
else
{
 $data = array("status" => 0, "msg" => "Request method not accepted");
}
@mysql_close($conn);

/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);


?>