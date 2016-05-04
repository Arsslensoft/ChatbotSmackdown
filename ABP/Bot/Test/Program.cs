using ABPS.Aiml;
using SchedulerManager.Mechanism;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading;
using System.Xml;

namespace Test
{
    /// <summary>
    /// A simple job which is executed only once.
    /// </summary>
    class SimgleExecutionJob : Job
    {
        public SimgleExecutionJob()
        {
            StartDate = DateTime.Parse("3/05/2016 18:31");
        }

        /// <summary>
        /// Get the Job Name, which reflects the class name.
        /// </summary>
        /// <returns>The class Name.</returns>
        public override string GetName()
        {
            return this.GetType().Name;
        }

        /// <summary>
        /// Execute the Job itself. Just print a message.
        /// </summary>
        public override void DoJob()
        {
            System.Console.WriteLine(String.Format("The Job \"{0}\" was executed.", this.GetName()));
        }

        /// <summary>
        /// Determines this job is not repeatable.
        /// </summary>
        /// <returns>Returns false because this job is not repeatable.</returns>
        public override bool IsRepeatable()
        {
            return false;
        }
        public override bool IsScheduled()
        {
            return true;
        }
        /// <summary>
        /// In case this method is executed NotImplementedException is thrown
        /// because this method is not to to be used. This method is never used
        /// because it serves the purpose of stating the interval of which the job
        /// will be executed repeatedly. Since this job is a single-execution one,
        /// this method is rendered useless.
        /// </summary>
        /// <returns>Returns nothing because this method is not to be used.</returns>
        public override int GetRepetitionIntervalTime()
        {
            throw new NotImplementedException();
        }
    }

    class Program
    {
        static void Main(string[] args)
        {

            // execute in ths project (asembly)
            JobManager jobManager = new JobManager();
            jobManager.ExecuteAllJobs();
            Console.Read();
            //Bot bot = new Bot(@"E:\Projects\Kavprot smart security\Bin");
        
            //bot.isAcceptingUserInput = false;
            //foreach (string file in Directory.GetFiles(@"E:\Projects\Kavprot smart security\Bin\aiml", "*.aiml"))
            //{
             
            //        XmlDocument doc = new XmlDocument();
            //        doc.Load(file);
            //        bot.loadAIMLFromXML(doc, file);
                
            //}

            //bot.loadSettings(@"E:\Projects\Kavprot smart security\Bin\config\Settings.xml");

            //bot.isAcceptingUserInput = true;

            //User u = new User("Arsslen", bot, @"E:\Projects\Kavprot smart security\Bin\");
            //string message = "Hi";
            //DateTime st = DateTime.Now;
            //while ((DateTime.Now - st) < new TimeSpan(0,1,0))
            //{
            //    Console.ForegroundColor = ConsoleColor.Green;
            //    Console.Write("BotA: " + message);
            //    string input = message;
      
            //        Request r = new Request(input, u, bot);
            //        Result res = bot.Chat(r);
            //        message = res.Output;
            //        Console.WriteLine();
            //        Console.ForegroundColor = ConsoleColor.Blue;
            //        Console.WriteLine("BotB: " + res.Output);

            //        r = new Request(message, u, bot);
            //        res = bot.Chat(r);
            //        message = res.Output;
            //        Console.WriteLine();
               
            //    Thread.Sleep(3000);
            //}
        }
    }
}
