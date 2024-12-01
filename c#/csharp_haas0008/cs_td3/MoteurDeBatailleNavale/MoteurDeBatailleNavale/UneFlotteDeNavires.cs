using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class UneFlotteDeNavires
    {
        public UnNavire[] Navires { get; }

        public UneFlotteDeNavires()
        {
            UnNavire[] listnav= new UnNavire[5];
            listnav[0]=(new UnNavire("porte avion", 5));
            listnav[1]=(new UnNavire("croiseur", 4));
            listnav[2]=(new UnNavire("contre torpilleur", 3));
            listnav[3]=(new UnNavire("sous-marin", 3));
            listnav[4] =(new UnNavire("torpilleur", 2));
            Navires = listnav;
        }

        public void RéparerTousLesNavires()
        {
            foreach(UnNavire navire in Navires)
            {
                navire.Réparer();
            }

        }

        public RésultatDeTir VérifierLeRésultatDuTir(CoordonnéesDeBatailleNavale caseCible)
        {
            RésultatDeTir res = RésultatDeTir.Raté;
            foreach(UnNavire navire in Navires)
            {
                RésultatDeTir tmp = navire.VérifierLeRésultatDuTir(caseCible);
                if (tmp != RésultatDeTir.Raté)
                {
                    res = tmp;
                }
            }
            if (res == RésultatDeTir.Raté || res== RésultatDeTir.Touché )
            {
                return res;
            }
            if (res ==RésultatDeTir.TouchéCoulé )
            {
                bool final = true;
                foreach (UnNavire navire in Navires)
                {
                    if (navire.Etat == EtatDeNavire.Intact)
                    {
                        final = false;
                    }
                }
                if (!final)
                {
                    return RésultatDeTir.TouchéCoulé;
                }
                else
                {
                    return RésultatDeTir.TouchéCouléFinal;
                }
            }
            return res;
        }
    }
}
