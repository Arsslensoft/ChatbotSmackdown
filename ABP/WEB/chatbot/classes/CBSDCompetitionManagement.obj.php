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
			$compet->Status= CompetitionStatus::Ready;
			$compet->save();
		}
		public function joinCompetition($cid, $bid)
		{

			$part = new Participation();
			$part->CompetitionId = $cid;
			$part->BotId = $bid;
			$part->JoinDate = date("Y-m-d H:i:s",time());
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
		public function getAllParticipations($cid)
		{

			$sql = "SELECT * FROM participations WHERE CompetitionId=".$cid;

			$parts = Participation::sql($sql);
			return $parts;
		}
		public function getParticipations($cid,$bid)
		{

			$sql = "SELECT * FROM participations WHERE CompetitionId=".$cid." AND BotId=".$bid;

			$parts = Participation::sql($sql);
			return $parts;
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
		public function voteForPlayer($pid)
		{

			$player = Player::retrieveByPK($pid);
			$player->Votes++;
			$player->save();
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
		public function getBot($id)
		{
			return User::retrieveByPK($id);
		}
		public function getRanking($cid, $bid)
		{
			$sql = "SELECT * FROM rankings WHERE CompetitionId=".$cid." AND BotId=".$bid;
			$ranks = Ranking::sql($sql);
			return $ranks;
		}

	}

	
?>