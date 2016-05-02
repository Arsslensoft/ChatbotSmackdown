using System;
using System.Text.RegularExpressions;
using System.Text;

namespace ABPS.Aiml.Normalize
{
    /// <summary>
    /// Strips any illegal characters found within the input string. Illegal characters are referenced from
    /// the bot's Strippers regex that is defined in the setup XML file.
    /// </summary>
    public class StripIllegalCharacters : ABPS.Aiml.Utils.TextTransformer
    {
        public StripIllegalCharacters(ABPS.Aiml.Bot bot, string inputString) : base(bot, inputString)
        { }

        public StripIllegalCharacters(ABPS.Aiml.Bot bot)
            : base(bot) 
        { }

        protected override string ProcessChange()
        {
            return this.bot.Strippers.Replace(this.inputString, " ");
        }
    }
}
