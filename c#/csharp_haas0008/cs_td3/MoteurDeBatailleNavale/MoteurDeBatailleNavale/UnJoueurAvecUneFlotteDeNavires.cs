using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public abstract class UnJoueurAvecUneFlotteDeNavires : IContratDuJoueurDeBatailleNavale
    {
        public UneFlotteDeNavires Flotte { get; }
        public string Pseudo
        {
            get;
        }

        public virtual void PréparerLaBataille() {}

        public abstract CoordonnéesDeBatailleNavale Attaquant_ChoisirLesCoordonnéesDeTir();

        public abstract RésultatDeTir Défenseur_FournirLeRésultatDuTir(CoordonnéesDeBatailleNavale coord);

        public abstract void Attaquant_GérerLeRésultatDuTir(CoordonnéesDeBatailleNavale coord, RésultatDeTir res);

        public UnJoueurAvecUneFlotteDeNavires(string pseudo)
        {
            if (pseudo == null || pseudo == "")
            {
                throw new ArgumentNullException("Pseudo null");
            }
            Pseudo = pseudo;
            Flotte = new UneFlotteDeNavires();
        }
    }

    
}
