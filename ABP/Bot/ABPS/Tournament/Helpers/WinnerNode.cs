﻿//-----------------------------------------------------------------------
// <copyright file="WinnerNode.cs" company="(none)">
//  Copyright (c) 2009 John Gietzen
//
//  Permission is hereby granted, free of charge, to any person obtaining
//  a copy of this software and associated documentation files (the
//  "Software"), to deal in the Software without restriction, including
//  without limitation the rights to use, copy, modify, merge, publish,
//  distribute, sublicense, and/or sell copies of the Software, and to
//  permit persons to whom the Software is furnished to do so, subject to
//  the following conditions:
//
//  The above copyright notice and this permission notice shall be
//  included in all copies or substantial portions of the Software.
//
//  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
//  EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
//  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
//  NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
//  BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
//  ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
//  CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
//  SOFTWARE
// </copyright>
// <author>Katie Johnson</author>
// <author>John Gietzen</author>
//-----------------------------------------------------------------------

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Diagnostics;
using System.Drawing;

namespace ABPS.Data.Standard
{
    [DebuggerDisplay("[WinnerNode: Level = {this.Level}, Decider = {this.Decider}]")]
    public class WinnerNode : EliminationNode
    {
        public WinnerNode(EliminationDecider decider)
            : base(decider)
        {
        }

        public override User Team
        {
            get
            {
                return this.decider.GetWinner();
            }
        }

        public override NodeMeasurement Measure( ABPS.Data.Graphics.IGraphics g, TournamentNameTable names, float textHeight)
        {
            return this.decider.MeasureWinner(g, names, textHeight, this.Score);
        }

        public override void Render( ABPS.Data.Graphics.IGraphics g, TournamentNameTable names, float x, float y, float textHeight)
        {
            this.decider.RenderWinner(g, names, x, y, textHeight, this.Score);
        }

        public override bool ApplyPairing(Game pairing)
        {
            if (pairing == null)
            {
                throw new ArgumentNullException("pairing");
            }

            if (this.IsDecided)
            {
                return false;
            }
            else
            {
                return this.decider.ApplyPairing(pairing);
            }
        }

        public override IEnumerable<Game> FindUndecided()
        {
            if (this.IsDecided)
            {
                yield break;
            }
            else
            {
                foreach (var undecided in this.Decider.FindUndecided())
                {
                    yield return undecided;
                }
            }
        }

        public override IEnumerable<EliminationNode> FindNodes(Func<EliminationNode, bool> filter)
        {
            if (filter.Invoke(this))
            {
                yield return this;
            }

            foreach (var match in this.Decider.FindNodes(filter))
            {
                yield return match;
            }
        }

        public override IEnumerable<EliminationDecider> FindDeciders(Func<EliminationDecider, bool> filter)
        {
            foreach (var match in this.Decider.FindDeciders(filter))
            {
                yield return match;
            }
        }
    }
}
