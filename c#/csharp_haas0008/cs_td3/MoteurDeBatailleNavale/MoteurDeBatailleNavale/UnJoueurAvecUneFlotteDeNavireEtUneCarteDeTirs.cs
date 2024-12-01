using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
     public abstract class  UnJoueurAvecUneFlotteDeNavireEtUneCarteDeTirs: UnJoueurAvecUneFlotteDeNavires
    {
        public CarteDesTirs CarteDesTirs { get;  }

        public UnJoueurAvecUneFlotteDeNavireEtUneCarteDeTirs(string pseudo) : base(pseudo)
        {
            CarteDesTirs=new CarteDesTirs();
        }

        public override void PréparerLaBataille()
        {
            base.PréparerLaBataille();
            CarteDesTirs.MiseAZéro();
        }

        public override RésultatDeTir Défenseur_FournirLeRésultatDuTir(CoordonnéesDeBatailleNavale coord)
        {
            return Flotte.VérifierLeRésultatDuTir(coord);
        }

        public override void Attaquant_GérerLeRésultatDuTir(CoordonnéesDeBatailleNavale coord, RésultatDeTir res)
        {
            CarteDesTirs.MarquerEmplacement(coord, res);
            Console.WriteLine($"Emplacement sélectionné : ({coord.Colonne},{coord.Ligne}) ");
            CarteDesTirs.DessinerDansLaConsole();
            if (res == RésultatDeTir.TouchéCouléFinal)
            {
                CarteDesTirs.DessinerDansLaConsoleFinal();
            }
        }
    }
}
