using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Text.RegularExpressions;
using CPile = CastleModel.Pile;
using MPile = CastleModel.Move.Pile;
using System.Threading.Tasks;

namespace CastleModel
{
    public class Move { 
        #region PileName
    public enum PileName 
    {
        COLUMN,
        DECK,
        HEAP,
        BASEHEAP

    }
        #endregion
        #region Pile
    public class Pile
    {
        public PileName Name { get; set; }
        public int? Number { get; set; }

            public override string ToString()
            {
                string nom = null;
                switch (Name)
                {
                    case PileName.COLUMN: 
                        nom = "Col";
                        break;
                    case PileName.DECK:
                        nom = "D";
                        break;
                    case PileName.HEAP:
                        nom = "H";
                        break;
                    case PileName.BASEHEAP:
                        nom = "Base";
                        break;
                }
                return $"{nom}{Number}";
            }
        }
        #endregion

        public Move.Pile From { get; set; }
        public Move.Pile? To { get; set; }
        public int CardsCount { get; set; }

        public Move(string piles, Castle castle)
        {
            piles = piles.ToUpper().Trim();
            Regex regex = new Regex(@"(?(D)^(?<pile1>D)$|^(?<pile1>[HC])(?<n1>\d)\s+(?<pile2>[CB])$)");
            //Regex regex = new Regex(@"^(?<pile1>D)$|^(?<pile1>H)(?<n1>[1-3])\s+(?<pile2>[BC])$"+ @" | ^(?< pile1 > C)(?< n1 >[1 - 6])\s + (?< pile2 >[CB])$");

            Match match = regex.Match(piles);

            if (!match.Success)
            {
                throw new ArgumentException($"Déplacement non reconnu dans la chaîne {piles}");
            }

            if (match.Groups["pile1"].Value == "D")
            {
                From = new Pile { Name = PileName.DECK, Number = 1 };
                To = null;
            }
            else
            {
                int nb = match.Groups["n1"].Value[0] - '0'; // Le nombre n’est constitué que d’un chiffre
                switch (match.Groups["pile1"].Value)
                {
                    case "H":
                        if (nb >= 1 && nb <= 3)
                        {
                            From = new Move.Pile { Name = PileName.HEAP, Number = nb };
                            CPile pile = castle.GetPile(From);
                            CardsCount = pile.Count;
                            break;
                        }
                        throw new ArgumentException($"Numéro de pile {nb} invalide pour un tas");

                    case "C":
                        if (nb >= 1 && nb <= 6)
                        {
                            From = new Pile { Name = PileName.COLUMN, Number = nb };
                            CPile pile = castle.GetPile(From);
                            CardsCount = pile.Count;
                            break;
                        }
                        throw new ArgumentException($"Numéro de pile {nb} invalide pour une colonne");
                }
                switch (match.Groups["pile2"].Value)
                {
                    case "B":
                        To = new Pile { Name = PileName.BASEHEAP, Number = null };
                        break;
                    case "C":
                        To = new Pile { Name = PileName.COLUMN, Number = null };
                        break;
                }
            }



        }

        public Move(CPile from, CPile? to)
        {
            this.From = from.MovePile;
            this.To = to is not  null  ? to.MovePile : null;
            CardsCount = from.Count;
        }

        public override string ToString()
        {
            if (To == null)
            {
                return $"{From}";
            }
            return $"{From} {To}";
        }
    }
}
