﻿//-----------------------------------------------------------------------
// <copyright file="IPluginEnumerator.cs" company="(none)">
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
// <author>John Gietzen</author>
//-----------------------------------------------------------------------

namespace ABPS.Tournaments.Plugins
{
    using System.Collections.Generic;

    /// <summary>
    /// Enumerates some or all of the plugins available in the assembly.
    /// </summary>
    /// <remarks>
    /// The application will search for instances of this interface in
    /// order to enumerate the plugins in the plugin assembly.
    /// </remarks>
    public interface IPluginEnumerator
    {
        /// <summary>
        /// Enumerates some or all of the plugins available in the assembly.
        /// </summary>
        /// <returns>An enumerable list of factories that can create plugins.</returns>
        IEnumerable<IPluginFactory> EnumerateFactories();
    }
}
