using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;

namespace ABPS.Data
{
    public enum CompetitionStatus
    {
  
        Ready,
        Started,
        Completed
    }
  public class Competition : DatabaseObject
    {
      public DateTime Start { get; set; }
      public string Name { get; set; }
      public string Description { get; set; }
      public CompetitionStatus Status { get; set; }
      // Prize
      public long PointsPerWin { get; set; }
      public long Prize { get; set; }
      public long ParticipantNumber { get; set; }


      public Competition()
      {
          Rounds = new List<Round>();
          Participations = new List<Participation>();
      }
      [InverseProperty("Competition")]
      public virtual List<Round> Rounds { get; set; }

      [InverseProperty("Competition")]
      public virtual List<Participation> Participations { get; set; }

      [InverseProperty("Competition")]
      public virtual List<Ranking> Rankings { get; set; }
    }
}
