using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Fichier.Model
{
    public class Citation
    {
        public Citation(string auteur, string texte) {
            Auteur = auteur;
            Texte = texte;
        }
        public Citation() { }
        public string Auteur { get; set; }
        public string Texte { get; set; }
    }
}
