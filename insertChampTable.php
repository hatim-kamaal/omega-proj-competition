<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 

/*
userId,numberOfPlayers,totalNumberOfMatches,currentNumberOfMatch,gameType,currentOpponentId,currentOpponentName,currentOpponentImg,currentOpponentScore,userName,userImg,currentUserScore,gameName,platform
*/
$userId=$jsondata->{'userId'};
$NumberOfPlayers=$jsondata->{'numberOfPlayers'};
$TotalNumberOfMatches=$jsondata->{'totalNumberOfMatches'};
$CurrentNumberOfMatch=$jsondata->{'currentNumberOfMatch'};
$GameType=$jsondata->{'gameType'};

$CurrentOpponentId=$jsondata->{'currentOpponentId'};

$CurrentOpponentName=$jsondata->{'currentOpponentName'};
$CurrentOpponentImg=$jsondata->{'currentOpponentImg'};
$CurrentOpponentScore=$jsondata->{'currentOpponentScore'};
$UserName=$jsondata->{'userName'};
$userImg=$jsondata->{'userImg'};
$CurrentUserScore=$jsondata->{'currentUserScore'};
$GameName=$jsondata->{'gameName'};
$Platform = $jsondata->{'platform'};


/*
$userId='2';
$NumberOfPlayers='100';
$TotalNumberOfMatches='7';
$CurrentNumberOfMatch='4';
$GameType='NUMERIC';
$CurrentOpponentId='3';
$CurrentOpponentName='Gaurav';
$CurrentOpponentImg='gaurav.png';
$CurrentOpponentScore='6';
$UserName='Ashish';
$userImg='ashish.png';
$CurrentUserScore='8';
$GameName='Call Of Duty';
$Platform='Play Station 4';
*/



if(isset($userId) && isset($NumberOfPlayers) && isset($TotalNumberOfMatches) && isset($GameType) && isset($CurrentOpponentId) && isset($CurrentOpponentName) && isset($CurrentOpponentImg) && isset($CurrentOpponentScore)&& isset($UserName)&& isset($userImg) &&isset($CurrentUserScore) && isset($GameName) && isset($Platform))

{


    $sql = "SELECT * FROM `ChampTable` WHERE `userId`='$userId' AND `CurrentOpponentId`='$CurrentOpponentId'";

 $sqlresult = mysql_query($sql);
 $count = mysql_num_rows($sqlresult);

     if ($count > 0)
     {

        
               $json = array('msg'=>"Already Registered");

   $sql1 = "UPDATE `ChampTable` SET `CurrentOpponentScore`='$CurrentOpponentScore',`CurrentUserScore`='$CurrentUserScore' WHERE `userId`='$userId' AND`CurrentOpponentId`='$CurrentOpponentId'";

    $sqlresult1 = mysql_query($sql1);

     if($sqlresult1)
     {
               $json = array('msg'=>"Score Updated");

     }
     else
    {
               $json = array('msg'=>"Score Can Not Updated");

    }
          
   }
     else
     {
     

                $insertQuery = "INSERT INTO `ChampTable`(`userId`, `NumberOfPlayers`, `TotalNumberOfMatches`,  `CurrentNumberOfMatch`, `GameType`, `CurrentOpponentId`,`CurrentOpponentName`, `CurrentOpponentImg`, `CurrentOpponentScore`, `UserName`, `userImg`, `CurrentUserScore`, `GameName`, `Platform`) VALUES ('$userId','$NumberOfPlayers','$TotalNumberOfMatches','$CurrentNumberOfMatch','$GameType', '$CurrentOpponentId','$CurrentOpponentName','$CurrentOpponentImg','$CurrentOpponentScore','$UserName','$userImg','$CurrentUserScore','$GameName','$Platform')";
 

       $insertQueryResult = mysql_query($insertQuery);
 
       if($insertQueryResult)
      {

       $json = array("status" => 1, "msg" => "Success");
      }
      else
       {
	  $json = array("status" => 0, "msg" => "Failure");
       }

    }

 
 }
     else
     { 
	  $json = array("status" => 0, "msg" => "Invalid Parameter");

     }


  }
   else
   {
     $json = array("status" => 0, "msg" => "Request method not accepted");
   }
 
@mysql_close($conn);
 
/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 
?>