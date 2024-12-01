using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class UneSectionDeNavire
    {
        public EtatDeSectionDeNavire Etat { get; set; }

        public CoordonnéesDeBatailleNavale Position { get; set; }

        public UneSectionDeNavire()
        {
            Position = new CoordonnéesDeBatailleNavale('A', 1);
            Etat = EtatDeSectionDeNavire.Intact;
        }
    }
}
