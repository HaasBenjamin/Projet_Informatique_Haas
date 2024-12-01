using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public interface IContratDuJoueurDeBatailleNavale
    {
         string Pseudo { get; }

        void PréparerLaBataille();


        CoordonnéesDeBatailleNavale Attaquant_ChoisirLesCoordonnéesDeTir();


        RésultatDeTir Défenseur_FournirLeRésultatDuTir(CoordonnéesDeBatailleNavale coord);


        void Attaquant_GérerLeRésultatDuTir(CoordonnéesDeBatailleNavale coord, RésultatDeTir res);
        
    }
}
