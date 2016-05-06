using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Tournaments;
using Tournaments.Plugins;
using Tournaments.Standard;

namespace ConsoleApplication1
{
    class Program
    {
       static private List<User> teams = new List<User>();
       static private List<TournamentRound> rounds = new List<TournamentRound>();
       static private EliminationTournament generator;
    
        static void Main(string[] args)
        {
            var p = new StandardTournamentsPluginEnumerator();

            var factories = from f in p.EnumerateFactories()
                            let pf = f as IPairingsGeneratorFactory
                            where pf != null
                            select pf;
      
            generator = (EliminationTournament)factories.ToList()[0].Create();

            teams.Add(new User(0, 100));
            teams.Add(new User(1, 100));

            
            generator.Reset();
            generator.LoadState(teams, rounds);
            // add winner
            TournamentRound round = generator.CreateNextRound(null);
            round.Pairings[0].TeamScores[0].Score = new HighestPointsScore(200);
            round.Pairings[0].TeamScores[1].Score = new HighestPointsScore(100);

            rounds.Add(round);

            var standings = generator.GenerateRankings();
            generator.Reset();
            generator.LoadState(teams, rounds);
            round = generator.CreateNextRound(null);
            Console.Read();
        }
    }
}
