using ABPS;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Bot
{
    class Program
    {
        static void Main(string[] args)
        {
            Console.Title = "Arsslensoft Bot Platform";
            Console.WriteLine("Copyright (c) 2010-2016 Arsslensoft. All rights reserved");
            Console.WriteLine("Copyright (c) 2015-2016 SDL Team. All rights reserved");
            Platform.Initialize(880, 120000);
            Platform.Start();

        }
    }
}
