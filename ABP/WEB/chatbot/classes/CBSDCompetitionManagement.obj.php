<?php

	class CBSDCompetitionManagement
	{

		public function createCompetition($start,$name,$description,$ppw, $prize, $pn)
		{
			$compet = new Competition;
			$compet->Start = $start;
			$compet->Name = $name;
			$compet->Description=$description;
			$compet->PointsPerWin = $ppw;
			$compet->ParticipantNumber = $pn;
			$compet->Prize = $prize;
			$compet->save();
		}
		public function joinCompetition($cid, $bid)
		{

			$part = new Participation();
			$part->CompetitionId = $cid;
			$part->BotId = $bid;
			$part->save();

		}
		public function getCompetition($id)
		{
			$compet = Competition::retrieveByPK($id);
			return $compet;
		}
		public function getAllCompetitions()
		{
				$compets = Competition::all();
			return $compets;
		}

		public function removeCompetition($id)
		{
			$compet = Competition::retrieveByPK($id);
			$compet->delete();
		}
		
		// Rounds Management
		public function getAllRounds($cid)
		{
			$sql = "SELECT * FROM rounds WHERE CompetitionId=".$cid;

			$rounds = Round::sql($sql);
			return $rounds;
		}
		public function getAllGames($rid)
		{
			$sql = "SELECT * FROM `games` WHERE RoundId=".$rid;

			$games = Game::sql($sql);
			return $games;
		}
		public function getAllPlayers($gid)
		{
			$sql = "SELECT * FROM players WHERE GameId=".$gid;
			$players = Player::sql($sql);
			return $players;
		}
		public function getAllRankings($cid)
		{
			$sql = "SELECT * FROM rankings WHERE CompetitionId=".$cid;
			$ranks = Ranking::sql($sql);
			return $ranks;
		}

		// Game Management
		public function voteForPlayer($gid, $bid)
		{

			$sql = "UPDATE `players` SET `Votes`=`Votes` + 1 WHERE GameId=? AND BotId = ?";
			if( !$this->stmt = $this->mysqli->prepare($sql) )
				throw new Exception("MySQL Prepare statement failed: ".$this->mysqli->error);

			$this->stmt->bind_param("ii",$gid,$bid);
			if( $this->stmt->execute() )
				true;
			return false;
		}
		public function getGame($gid)
		{
			$game = Game::retrieveByPK($gid);
			return $game;
		}
		public function getPlayer($pid)
		{
			$player = Player::retrieveByPK($pid);
			return $player;
		}

	}

	
?>