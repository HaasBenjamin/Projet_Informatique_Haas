using MoteurDeBatailleNavale;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Reflection;
using System.Text;
using System.Threading.Tasks;

namespace TestsDuMoteurDeBatailleNavale
{
    [TestClass]
   public class testPhase3{
        [TestMethod]
        public void CarteDesTirs_MiseAZero()
        {
            CarteDesTirs carte = new CarteDesTirs();
            carte.MiseAZéro();
            for (char colonne = 'A'; colonne < 'K'; colonne++)
                for (byte ligne = 1; ligne < 11; ligne++)
                {
                    Assert.IsTrue(carte.VérifierEmplacement(new CoordonnéesDeBatailleNavale(colonne,
                   ligne)) == RésultatDeTir.Inconnu);
                }
        }
        [TestMethod]
        public void CarteDesTirs_VerifierTirs()
        {
            CarteDesTirs carte = new CarteDesTirs();
            carte.MiseAZéro();
            for (char colonne = 'A'; colonne < 'K'; colonne++)
                for (byte ligne = 1; ligne < 11; ligne++)
                {
                    CoordonnéesDeBatailleNavale coord = new CoordonnéesDeBatailleNavale(colonne,
                   ligne);
                    RésultatDeTir res = RésultatDeTir.Touché;
                    carte.MarquerEmplacement(coord, res);
                    Assert.IsTrue(carte.VérifierEmplacement(coord) == RésultatDeTir.Touché);
                }
        }
    }
    
    

}
