using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;

namespace Fichier.Model
{
    public class ListCitations
    {
        private readonly List<Citation> __data = new List<Citation>()
    {
     new Citation
     {
     Texte = "Si j'avais à écrire ici un livre de morale, il aurait cent pages et quatre-vingt-dix-neuf seraient blanches.",
     Auteur = "Albert Camus"
     },
     new Citation
     {
     Texte =
     "Le monde est dangereux à vivre ! Non pas tant à cause de ceux qui font le mal, mais à cause de ceux qui regardent et laissent faire.",
     Auteur = "Albert Einstein"
     },
     new Citation
     {
     Texte = "Ce que l'on ne désire pas pour soi, ne pas le faire à autrui.",
     Auteur = "Confucius"
     },
     new Citation
     {
     Texte = "J'ai été étonné du plaisir qu'on éprouve en faisant le bien.",
     Auteur = "Pierre Choderlos de Laclos"
     },
     new Citation
     {
     Texte = "C'est le devoir de chaque homme de rendre au monde au moins autant qu'il en a reçu.",
     Auteur = "Albert Einstein"
     },
     new Citation
     {
     Texte = "Nous pesons rarement dans la même balance les offenses que nous faisons et les offenses que l'on nous fait.",
     Auteur = "Esope"
     },
     new Citation
     {
     Texte =
     "Désirer se grandir pour être à même d'autrui est parfaitement moral. La loi moral la plus élevée pousse chaucun à oeuvrer inlassablement pour le bien de l'humanité.",
     Auteur = "Gandhi"
     },
     new Citation
     {
     Texte =
     "Il n'ya a que deux choses immuables et éternelles : le ciel étoilé au-dessus de nos têtes, et la loi morale au fond de nos coeurs.",
     Auteur = "Emmanuel Kant"
     },
     new Citation
     {
     Texte =
     "Voici la morale parfaite : vivre chaque jour comme si c'était le dernier, ne pas s'agiter, ne pas sommeiller, ne pas faire semblant.",
     Auteur = "Marc Aurèle"
     },
     new Citation
     {
     Texte = "Pour être un membre irréprochable parmi une communauté de moutons, il faut être soi-même un mouton.",
     Auteur = "Albert Einstein"
     },
     new Citation
     {
     Texte = "On doit vivre sa vie en essayant d'en faire un modèle pour les autres.",
     Auteur = "Rosa Parks"
     },
     new Citation
     {
     Texte =
     "Deux choses sont infinies : l'Univers et la bêtise humaine. Mais en ce qui concerne l'Univers, je n'en ai pas encore acquis la certitude absolue.",
     Auteur = "Albert Einstein"
     },
    };

        private IList<Citation>? citations;

        private void Load()
        {
            citations = new List<Citation>();
            foreach (var citation in __data) {
            citations.Add(citation);
            }
        }

        public IList<Citation> Citations
        {
            get
            {
                if (citations == null)
                {
                    Load();
                }
                return citations;
            }
        }

        public string SaveToJson()
        {
            return JsonSerializer.Serialize(citations);
        }

        public void LoadFromJson(string citationsSer)
        {
            if (citations != null && citations.Count ==0)
            {
                citations.Clear();
            }
            citations = new List<Citation>();
            foreach (var citation in JsonSerializer.Deserialize<List<Citation>>(citationsSer))
            {
                citations.Add(citation);
            }

        }
    }
}
