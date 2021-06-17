<html>
<head>
<title>Vk</title>
</head>
<body>
<?php
class Chest
{
	private $chestType="";
	private $chestScore=0;

	public function SetType($_chestType)
	{
		$this->chestType=$_chestType;
		if( $this->chestType=="common")
		{
			$this->chestScore=rand(0, 5);
		}
		if( $this->chestType=="rare")
		{
			$this->chestScore=rand(5, 10);
		}
		if( $this->chestType=="epic")
		{
			$this->chestScore=rand(10, 25);
		}
	}
	public function GetType()
	{
		return $this->chestType;
	}
	public function GetScore()
	{
		return $this->chestScore;
	}
}
class Enemy
{
	private $enemyType="";
	private $enemiescore=0;
	private $enemyPower=0;
	private $enemyPowerLose=0;
	
	public function SetType($_enemyType)
	{
		$this->enemyType=$_enemyType;
		if( $this->enemyType=="fly")
		{
			$this->enemiescore=rand(2, 7);
			$this->enemyPowerLose=rand(1, 5);
		}
		if( $this->enemyType=="under")
		{
			$this->enemiescore=rand(5, 15);
			$this->enemyPowerLose=rand(3, 9);
		}
		if( $this->enemyType=="boss")
		{
			$this->enemiescore=rand(10, 25);
			$this->enemyPowerLose=rand(5, 13);
		}
		$enemyPower=$enemiescore;
	}
	public function GetType()
	{
		return $this->enemyType;
	}
	public function GetCurrentPower()
	{
		$this->enemyPower;
	}
	public function Damage()
	{
		$this->enemyPower -= $this->enemyPowerLose;
	}
	public function Lose()
	{
		return $this->enemiescore;
	}
}
class Room
{
	private $roomType="";

	private $doorUp=false;
	private $doorLeft=false;
	private $doorDown=false;
	private $doorRight=false;
	
	private $posX = 0;
	private $posY = 0;

	private $isVisited=false;

	private $chest;
	private $enemy;

	public function SetType($_roomType)
	{
		$this->roomType=$_roomType;
	}
	public function GetType()
	{
		return $this->roomType;
	}
	public function SetPosition($_positionX,$_positionY)
	{
		$this->posX = $_positionX;
		$this->posY = $_positionY;
	}
	public function GetPositionX()
	{
		return $this->posX;
	}
	public function GetPositionY()
	{
		return $this->posY;
	}
	public function SetDoor()	
	{
		$this->doorUp = $_doorUp;
		$this->doorRight = $_doorRight;
		$this->doorDown = $_doorDown;
		$this->doorLeft = $_doorLeft;
	}
	public function GetDoorUP()	
	{
		return $this->doorUp;
	}
	public function GetDoorRight()	
	{
		return $this->doorRight;
	}
	public function GetDoorDown()	
	{
		return $this->doorDown;
	}
	public function GetDoorLeft()	
	{
		return $this->doorLeft;
	}
	public function SetChest($_chest)
	{
		$this->chest= $_chest;
	}
	public function GetChest()
	{
		return $this->chest;
	}
	public function SetEnemy($_enemy)
	{
		$this->enemy = $_enemy;
	}
	public function GetEnemy()
	{
		return $this->enemy;
	}
	public function VisitRoom()
	{
		$this->isVisited = true;
	}
	public function GetVisitRoom()
	{
		return $this->isVisited;
	}
}
class Dungeon
{
	private $dungeonSize;
	private $roomCount;
	private $rooms = [];

	public function SetDungeonSize($_dungeonSize)
	{
		$this->dungeonSize=$_dungeonSize;
	}
	public function GetDungeonSize()
	{
		return $this->dungeonSize;
	
	}public function SetRoomCount($_roomCount)
	{
		$this->roomCount=$_roomCount;
	}
	public function GetRoomCount()
	{
		return $this->roomCount;
	}
	public function SetRoom(...$_rooms)
	{
		foreach ($_rooms as $room) {
			$rooms[] = $room;
		}
	}
	public function GetRoom($_positionX,$_positionY)
	{
		foreach ($rooms as $room) {
			if($room->GetPositionX()==$_positionX && $room->GetPositionY()==$_positionY)
			{
				return $room;
			}
		}
	}
}
class Player
{
	private $score = 0;

	private $posX = 0;
	private $posY = 0;

	public function GetScore()
	{
		return $this->score;
	}
	public function AddScore($score)
	{
		if($this->score+$score>0)
		{
			$this->score+=$score;
		}
	}

	public function Interact(&$dungeon)
	{
		$room = &$dungeon->GetRoom($this->posX, $this->posY);
		if($room->GetType() == "chestRoom" && !$room->GetVisitRoom())
		{
			AddScore($room->GetChest()->GetScore());
			$room->VisitRoom();
		}
		if($room->GetType() == "enemyRoom" && !$room->GetVisitRoom())
		{
			$enemy = &$room->GetEnemy();
			while($enemy->GetCurrentPower()>0)
			{
				$damage=rand(0, 26);
				if($damage<$enemy->GetCurrentPower())
				{
					$enemy->Damage();
				}
			}
			AddScore($enemy->GetScore());
			$room->VisitRoom();
		}
		if($room->GetType() == "finishRoom")
		{
			$plyScoreFile = 'plyScore.txt';
			$scoreText = ''.$ply->GetScore();
			file_put_contents($plyScoreFile, $scoreText);
		}

	}

	public function Spawn($positionX,$positionY)
	{
		$this->posX = $positionX;
		$this->posY = $positionY;
	}

	function displayPosition()
	{
	echo "($this->posX;$this->posY)<br>";
	}

	function Move ( $_side, $_canMove, &$dungeon)
	{
		$room = &$dungeon->GetRoom($this->posX, $this->posY);
		if($_side=="up" && $room->GetDoorUP())
		{
			$positionY ++;
			Interact($dungeon);
		}
		if($_side=="right" && $room->GetDoorRight())
		{
			$positionX ++;
			Interact($dungeon);
		}
		if($_side=="down" && $room->GetDoorDown())
		{
			$positionY --;
			Interact($dungeon);
		}
		if($_side=="left" && $room->GetDoorLeft())
		{
			$positionX --;
			Interact($dungeon);
		}
	}

}
$dungeon = new Dungeon();
if (isset($_POST['dungeonSize'])) 
{ 
	$dungeon->SetDungeonSize($_POST['dungeonSize']);
}
if (isset($_POST['dungeonSize'])) 
{ 
	$dungeon->SetRoomCount($_POST['roomCount']);
}
if (isset($_POST['rooms'])) 
{ 
	$dungeon->SetRoom($_POST['rooms']);
}
function SetRoom($roomPosX,$roomPosY,$roomType,$chestType,$enemyType)
{
	$room = &$dungeon->GetRoom($_POST[$roomPosX],$_POST[$roomPosY]);
	$room->SetType($_POST[$roomType]);
	if($room->GetType() == "chestRoom")
	{
		$chest = new Chest();
		$chest->SetType($_POST[$chestType]);
		$room->SetChest($chest);
	}	
	if($room->GetType() == "enemyRoom")
	{
		$enemy = new Enemy();
		$enemy->SetType($_POST[$enemyType]);
		$room->SetChest($enemy);
	}
}
$ply = new Player();
$StartRoomPosX=$_GET["StartRoomPosX"];
$StartRoomPosY=$_GET["StartRoomPosY"];
$ply->Spawn($StartRoomPosX,$StartRoomPosY);
?>
</body>
</html>
