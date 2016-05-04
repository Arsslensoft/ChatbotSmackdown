using ABPS.Data;
using ABPS.Tournaments;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using System.Threading.Tasks;
using System.Timers;

namespace ABPS
{
  public static class TournamentManager
    {
      public static JobManager jobManager = new JobManager();
      public static List<TournamentInstance> Tournaments { get; set; }
      public static void Initialize()
      {
          Tournaments = new List<TournamentInstance>();
      }
      public static void Reload()
      {

          Platform.Load();
          List<Competition> compet = Platform.DBManager.Competitions.ToList();
          foreach (Competition cpt in compet)
          {
              if (Tournaments.Where(x => x.Competition.Id == cpt.Id).Count() == 0)
              {
                  TournamentInstance tour = new TournamentInstance(cpt);
                  Tournaments.Add(tour);
                  jobManager.ExecuteJob(tour);
              }
          }


      }
    
  
    }
}
