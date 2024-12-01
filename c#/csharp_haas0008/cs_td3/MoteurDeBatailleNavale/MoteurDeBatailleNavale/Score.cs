using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public  class Score
    {
        public DateTime DateEtHeureDePartie { get; set; }
        public string PseudoGagnant {  get; set; }
        public string PseudoPerdant { get; set; }
        public int NbTirs { get; set; }

        public Score(string pseudoGagnant, string pseudoPerdant, int nbTirs)
        {
            DateEtHeureDePartie = DateTime.Now;
            PseudoGagnant = pseudoGagnant;
            PseudoPerdant = pseudoPerdant;
            NbTirs = nbTirs;
        }

        public Score() { }
    }
}
