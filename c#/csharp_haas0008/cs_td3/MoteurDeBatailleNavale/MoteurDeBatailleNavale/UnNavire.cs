using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace MoteurDeBatailleNavale
{
    public class UnNavire
    {
        public string Nom { get; }
        public EtatDeNavire Etat { get; private set; }

        public OrientationNavire Orientation { get; private set; }

        public UneSectionDeNavire[] Sections  { get; }

        public UnNavire(string name, byte nbsections)
        {
            if (name == "" || name == null)
            {
                throw new ArgumentNullException("Le nom du navire est null");
            }
            if (nbsections < 2 || nbsections > 5)
            {
                throw new ArgumentOutOfRangeException("Nombre de sections invalide");
            }
            UneSectionDeNavire[] listnav = new UneSectionDeNavire[nbsections];
            for (byte i = 0; i < nbsections; i++)
            {
                listnav[i] = (new UneSectionDeNavire());
            }
            Sections = listnav;
            Nom = name;
            Etat = EtatDeNavire.Intact;
        }
        private UnNavire() { }

        public void Réparer()
        {
            foreach (UneSectionDeNavire section in Sections)
            {
                section.Etat = EtatDeSectionDeNavire.Intact;
            }
            Etat = EtatDeNavire.Intact;
        }
        public void Positionner(CoordonnéesDeBatailleNavale coordonnées, OrientationNavire orientation)
        {
            int pos = -1;
            this.Sections[0].Position = coordonnées;
            Orientation = orientation;
            
            for (int i = 1; i < this.Sections.Length; i++)
            {
                if (orientation == OrientationNavire.Vertical)
                {
                    this.Sections[i].Position = new CoordonnéesDeBatailleNavale(coordonnées.Colonne, (byte)(coordonnées.Ligne + i));
                }
                else
                {
                    char colonne = (char)(coordonnées.Colonne + i);
                    this.Sections[i].Position = new CoordonnéesDeBatailleNavale(colonne, coordonnées.Ligne);
                }
            }
        }

        public RésultatDeTir VérifierLeRésultatDuTir(CoordonnéesDeBatailleNavale caseCible)
        {
            bool touche = false;
            foreach(UneSectionDeNavire nav in Sections)
            {
                if (nav.Position.Colonne== caseCible.Colonne && nav.Position.Ligne == caseCible.Ligne)
                {
                    touche = true;
                    nav.Etat = EtatDeSectionDeNavire.Touché;
                }
            }
            if (!touche)
            {
                return RésultatDeTir.Raté;
            }
            bool coule = true;
            foreach (UneSectionDeNavire nav in Sections)
            {
                if (nav.Etat == EtatDeSectionDeNavire.Intact)
                {
                    coule = false;
                }
            }
            if (coule)
            {
                Etat = EtatDeNavire.Coulé;
                return RésultatDeTir.TouchéCoulé;
            }
            return RésultatDeTir.Touché;

        }
    }

    
}
