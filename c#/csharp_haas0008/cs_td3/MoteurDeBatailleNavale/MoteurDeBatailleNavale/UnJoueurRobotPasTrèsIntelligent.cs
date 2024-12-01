using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class UnJoueurRobotPasTrèsIntelligent : UnJoueurAvecUneFlotteDeNavires
    {
        public UnJoueurRobotPasTrèsIntelligent(string pseudo): base(pseudo)
        {

        }

        private void MettreTousLesNaviresAuPort(UneFlotteDeNavires flotte)
        {
            byte ligne = 1;
            foreach (UnNavire navire in flotte.Navires)
            {
                navire.Positionner(new CoordonnéesDeBatailleNavale('A', ligne++),
               OrientationNavire.Horizontal);
            }
        }

        public override void PréparerLaBataille()
        {
            base.PréparerLaBataille();
            MettreTousLesNaviresAuPort(Flotte);
        }

        public override CoordonnéesDeBatailleNavale Attaquant_ChoisirLesCoordonnéesDeTir()
        {
            Random rnd = new Random();
            int randIndex = rnd.Next(10);
            byte ligne = CoordonnéesDeBatailleNavale.ligneposs[randIndex];
            randIndex = rnd.Next(10);
            char colonne = CoordonnéesDeBatailleNavale.colposs[randIndex];
            Console.WriteLine($"Coordonnée choisie = ({colonne},{ligne})");
            return new CoordonnéesDeBatailleNavale(colonne, ligne);
        }

        public override void Attaquant_GérerLeRésultatDuTir(CoordonnéesDeBatailleNavale coord, RésultatDeTir res) { }

        public  override RésultatDeTir  Défenseur_FournirLeRésultatDuTir(CoordonnéesDeBatailleNavale coord)
        {
            RésultatDeTir res = base.Flotte.VérifierLeRésultatDuTir(coord);
            Console.WriteLine($"Pour la case de coordonnées ({coord.Colonne},{coord.Ligne}) la réponse du défenseur est {Enum.GetName(typeof(RésultatDeTir), res)} ");
            return res;
        }





    }
}
