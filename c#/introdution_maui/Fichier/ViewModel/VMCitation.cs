using Fichier.Model;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;

namespace Fichier.ViewModel
{
    public class VMCitation: INotifyPropertyChanged
    {
        private readonly Citation citation;

        public Citation Citation { get { return citation; } }

        public event PropertyChangedEventHandler? PropertyChanged;
        private void NotifyPropertyChanged([CallerMemberName] string prop = "")
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(prop));
        }

        public string Auteur { get { return citation.Auteur; } 
            set { 
                if (citation.Auteur != value)
                {  citation.Auteur = value;
                    NotifyPropertyChanged(nameof(Auteur));
                }
                }
        }
        public string Texte
        {
            get { return citation.Texte; }
            set
            {
                if (citation.Texte != value)
                { citation.Texte = value;
                    NotifyPropertyChanged(nameof(Texte));
                }
            }
        }

        public VMCitation()
        {
            citation = new Citation();
        }

        public VMCitation(Citation citation)
        {
            this.citation = citation; //  new Citation(citation.Auteur,citation.Texte);
        }
    }
}
