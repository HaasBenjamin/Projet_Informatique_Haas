using MoteurDeBatailleNavale;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace JouerUnePartieDeBatailleNavale_
{
    public static class ExtensionsDeLaClasseScore
    {
        public static string AffichagePropre(this Score score)
        {
            return String.Format("Vainqueur {0} contre {1} en {2} tirs (le {3})", new
           object[] { score.PseudoGagnant, score.PseudoPerdant, score.NbTirs,score.DateEtHeureDePartie });
        }
    }
}
