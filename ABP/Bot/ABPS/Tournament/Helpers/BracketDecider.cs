namespace ABPS.Data.Standard.Helpers
{
    using System;
    using System.Collections.Generic;

    public class BracketDecider : EliminationDecider
    {
        private List<EliminationNode> bracketRootNodes = new List<EliminationNode>();

        public BracketDecider(IEnumerable<EliminationNode> bracketRootNodes)
        {
           this.bracketRootNodes.AddRange(bracketRootNodes);
        }

        public BracketDecider(params EliminationNode[] bracketRootNodes)
        {
            this.bracketRootNodes.AddRange(bracketRootNodes);
        }

        public override bool IsDecided
        {
            get
            {
                return false;
            }
        }

        public override User GetWinner()
        {
            throw new NotImplementedException();
        }

        public override User GetLoser()
        {
            throw new NotImplementedException();
        }

        public override bool ApplyPairing(Game pairing)
        {
            throw new NotImplementedException();
        }

        public override IEnumerable<Game> FindUndecided()
        {
            throw new NotImplementedException();
        }

        public override IEnumerable<EliminationNode> FindNodes(Func<EliminationNode, bool> filter)
        {
            throw new NotImplementedException();
        }

        public override IEnumerable<EliminationDecider> FindDeciders(Func<EliminationDecider, bool> filter)
        {
            throw new NotImplementedException();
        }

        public override NodeMeasurement MeasureWinner( ABPS.Data.Graphics.IGraphics g, TournamentNameTable names, float textHeight, Score score)
        {
            throw new NotImplementedException();
        }

        public override NodeMeasurement MeasureLoser( ABPS.Data.Graphics.IGraphics g, TournamentNameTable names, float textHeight, Score score)
        {
            throw new NotImplementedException();
        }

        public override void RenderWinner( ABPS.Data.Graphics.IGraphics g, TournamentNameTable names, float x, float y, float textHeight, Score score)
        {
            throw new NotImplementedException();
        }

        public override void RenderLoser( ABPS.Data.Graphics.IGraphics g, TournamentNameTable names, float x, float y, float textHeight, Score score)
        {
            throw new NotImplementedException();
        }
    }
}
