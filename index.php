<html>
<head>
<title>Vk</title>
</head>
<body>
<?php

if (isset($_POST['dungeonSize'])) { $dungeonSize = $_POST['dungeonSize']; if ($dungeonSize == '') { unset($dungeonSize);} }
if (isset($_POST['dungeonMap'])) { $dungeonMap=$_POST['dungeonMap']; if ($dungeonMap =='') { unset($dungeonMap);} }

class Dungeon
{
	private $dungeonSize;
	private $roomCount;
	private Room rooms = [];
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

	private Chest chests = [];
	private Enemy enemies = [];
}

class Chest
{
	private $chestType;
	private $chestScore=0;

	if( $chestType=="common")
	{
		$chestScore=rand(0, 5);
	}
	if( $chestType=="rare")
	{
		$chestScore=rand(5, 10);
	}
	if( $chestType=="epic")
	{
		$chestScore=rand(10, 25);
	}
}
class Enemy
{
	private $enemyType;
	private $enemiescore=0;
	private $enemyPower=$enemiescore;
	private $enemyPowerLose=0;

	if( $chestType=="fly")
	{
		$enemiescore=rand(2, 7);
		$enemyPowerLose=rand(1, 5);
	}
	if( $chestType=="under")
	{
		$enemiescore=rand(5, 15);
		$enemyPowerLose=rand(3, 9);
	}
	if( $chestType=="boss")
	{
		$enemiescore=rand(10, 25);
		$enemyPowerLose=rand(5, 13);
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
		if($dungeon.rooms.posX = $this->posX && $dungeon.rooms.posY = $this->posY && $dungeon.rooms.roomType == "chestRoom" && !$isVisited)
		{
			AddScore($dungeon.rooms.chests.score);
			$dungeon.rooms.isVisited=true;
		}
		if($dungeon.rooms.posX = $this->posX && $dungeon.rooms.posY = $this->posY && $dungeon.rooms.roomType == "enemyRoom" && !$isVisited)
		{
			while($dungeon.rooms.enemies.enemyPower>0)
			{
				$damage=rand(0, 26);
				if($damage<$dungeon.rooms.enemies.enemyPower)
				{
					$dungeon.rooms.enemies.enemyPower-=$dungeon.rooms.enemies.enemyPowerLose;
				}
			}
			AddScore($dungeon.rooms.enemies.enemiescore);
			$dungeon.rooms.isVisited=true;
		}
		if($dungeon.rooms.posX = $this->posX && $dungeon.rooms.posY = $this->posY && $dungeon.rooms.roomType == "finishRoom")
		{
			$plyScoreFile = 'plyScore.txt';
			$scoreText = 'Score: '. $ply->GetScore();
			file_put_contents($plyScoreFile, $scoreText);
			Restart();
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

	function Move ( $_side, $_canMove, $dungeon)
	{
		if($_side=="up" && $dungeon.rooms.doorUp)
		{
			$positionY ++;
			Interact(&$dungeon);
		}
		if($_side=="right" && $dungeon.rooms.doorRight)
		{
			$positionX ++;
			Interact(&$dungeon);
		}
		if($_side=="down" && $dungeon.rooms.doorDown)
		{
			$positionY --;
			Interact(&$dungeon);
		}
		if($_side=="left" && $dungeon.rooms.doorLeft)
		{
			$positionX --;
			Interact(&$dungeon);
		}
	}

}
$ply = new Player();
echo "Score: ". $ply->GetScore() . "<br>";
$ply->displayPosition();
$StartRoomPosX=$_GET["StartRoomPosX"];
$StartRoomPosY=$_GET["StartRoomPosY"];
$ply->Spawn($StartRoomPosX,$StartRoomPosY);
$ply->displayPosition();
$plyScoreFile = 'plyScore.txt';
$scoreText = 'Score: '. $ply->GetScore();
file_put_contents($plyScoreFile, $scoreText);
?>
</body>
</html>
