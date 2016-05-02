using ABPS.Aiml;
using ABPS.Data;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace ABPS
{
  public class Chatbot
    {
      public string BotPath
      {
          get { return Path.Combine(Environment.CurrentDirectory, "bots", User.Id.ToString());}
      }
      public string PersonalityPath
      {
          get { return Path.Combine(BotPath , "personality"); }
      }
      public string AIMLPath
      {
          get { return Path.Combine(BotPath, "aiml"); }
      }


      public ABPS.Aiml.Bot BotEngine { get; set; }
      public ABPS.Data.User User { get; set; }
      public List<ABPS.Aiml.User> Visitors { get; set; }
      public Chatbot(ABPS.Data.User user)
      {
          User = user;
          BotEngine = new Bot();
          BotEngine.loadSettings();
          Visitors = new List<ABPS.Aiml.User>();
          BotPath = Path.Combine(Environment.CurrentDirectory, "bots");
          BotPath = Path.Combine(BotPath, user.Id.ToString());
          if (!Directory.Exists(BotPath))
              Directory.CreateDirectory(BotPath);

      }
      private void ReloadPersonality()
      {
          foreach (Personality ai in User.Personalities)
          {
              if (ai.Active)
                  BotEngine.loadSettings(Path.Combine(PersonalityPath ,ai.PersonalityFile));
              
          }
      }
      private void ReloadAimlSets()
      {
       
          foreach (AimlSet ai in User.AimlSets)
          {
              if (ai.Load)
              {
                  XmlDocument doc = new XmlDocument();
                  doc.Load(Path.Combine(AIMLPath, ai.AimlFile));
                  BotEngine.loadAIMLFromXML(doc, Path.Combine(AIMLPath, ai.AimlFile));
              }
          }

      }
      public void ReloadBot()
      {
          BotEngine = new Bot();
          BotEngine.isAcceptingUserInput = false;
          ReloadPersonality();
          ReloadAimlSets();
          BotEngine.isAcceptingUserInput = true;
          Visitors.Clear();
          foreach (Visitor v in User.Visitors)
              AddVisitor(v);
      }
      public void AddVisitor(Visitor vis)
      {
          Visitors.Add(new ABPS.Aiml.User(vis.VisitorIdentifier, BotEngine));
      }
      public ABPS.Aiml.User GetVisitor(Visitor v)
      {
          foreach (ABPS.Aiml.User u in Visitors)
              if (u.UserID == v.VisitorIdentifier)
                  return u;

          AddVisitor(v);
          return new ABPS.Aiml.User(v.VisitorIdentifier, BotEngine);
      }
      public string Answer(string message, Visitor v)
      {

          Request r = new Request(message, GetVisitor(v), BotEngine);
          Result res = BotEngine.Chat(r);
          return res.Output;
      }


    }
}
