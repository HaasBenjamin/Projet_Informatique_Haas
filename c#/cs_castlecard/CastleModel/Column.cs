using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace CastleModel
{
    public class Column:Pile
    {
        public override bool CanPush(Card c)
        {
            return c.CanCover(this.Last); 
        }

        public override Move.Pile MovePile
        {
            get
            {
                Move.Pile pile = new Move.Pile();
                pile.Name = Move.PileName.COLUMN;
                pile.Number = this.Number;
                return pile;

            }
        }

        public virtual Card? CardToMove
        {
            get
            {
                return First;
            }
        }

        public Column(int number = 0)
        {
            this.Number = number;
            this.Name = "C";
        }

        public Card? First
        {
            get { 
                return this.Empty ? null : cards[0]; 
            }
        }

        public override void ApplyMove(Castle castle, Move move)
        {
            Pile pile = castle.GetPile(move.From);
            if (pile.Empty)
            {
                throw new ArgumentException($"La pile source {move.From.Name}{move.From.Number} est vide !");
            }
            if (move.To == null)
            {
                Column fromcol = (Column)pile;
                Pile dest = castle.SearchPileForCard(fromcol.First);
                if (dest == null)
                {                 
                    dest = castle.SearchPileForCard(fromcol.Last);
                }
                if (dest != null)
                {
                    Move.Pile topile = new Move.Pile();
                    topile.Number = dest.Number;
                    Move.PileName pilename = Move.PileName.BASEHEAP;
                    if (dest.Name == "C")
                    {
                        pilename = Move.PileName.COLUMN;
                    }
                    
                    topile.Name = pilename;
                }


            }
            if (move.To != null)
            {

            
            if (move.To.Name == Move.PileName.BASEHEAP)
            {
                int? basenum = castle.GetBaseHeapFor(Last);
                if (null == basenum)
                {
                    throw new ArgumentException($"Aucun déplacement possible depuis la colonne {move.From.Name}{move.From.Number} vers une pile de base");
                }
                else
                {
                    Move.Pile basepile = new Move.Pile();
                    basepile.Number = basenum;
                    basepile.Name = Move.PileName.BASEHEAP;
                    Pile baseHeap = castle.GetPile(basepile);
                    move.To.Number = baseHeap.Number;

                    for (int i = 0; i < this.cards.Count; i++)
                    {
                        baseHeap.Push(this.cards[this.cards.Count - i - 1]);
                    }
                    this.cards.Clear();

                }
            }
            else if (move.To.Name == Move.PileName.COLUMN)
            {
                int? colnum = castle.GetColumnFor(First, false);
                if (null == colnum)
                {
                    throw new ArgumentException($"Aucun déplacement possible depuis la colonne {move.From.Name}{move.From.Number} vers une colonne");
                }
                else
                {
                    Move.Pile colpile = new Move.Pile();
                    colpile.Number = colnum.Value;
                    colpile.Name = Move.PileName.COLUMN;
                    Pile colonne = castle.GetPile(colpile);
                    move.To.Number = colonne.Number;
                    for (int i = 0; i < this.cards.Count; i++)
                    {
                        colonne.Push(this.cards[i]);
                    }
                    this.cards.Clear();
                }
            }
        }
        }

        public override void UndoMove(Pile? to, int cardsCount)
        {
            for (int i = 0; i < cardsCount; i++)
            {
                Push(to.Pop());
            }
        }

        public override string Encode()
        {
            StringBuilder repres = new StringBuilder("");
            if (!Empty)
            {
                repres.Append(First.Encode());
                repres.Append(Last.Encode());
            }
            return repres.ToString();
        }

        public override void Decode(string cartes)
        {
            if (!(cartes.Length == 0 || cartes.Length == 2) )
            {
                throw new ArgumentException("L’encodage ne doit contenir que 0 ou 2 caractères");
            }
            this.cards.Clear();
            if (cartes.Length == 2)
            {
                Card carte_dessus = Card.Decode(cartes[0]);
                Card carte_dessous = Card.Decode(cartes[1]);
                if ((carte_dessous.Figure.Value > carte_dessus.Figure.Value) || (carte_dessous.Color != carte_dessus.Color))
                {
                    throw new ArgumentException("Dans l’encodage, la valeur de la première carte doit être supérieure à celle de la seconde et les cartes doivent être de même couleur.");
                }
                int nummax = carte_dessus.Figure.Value;
                int nummin = carte_dessous.Figure.Value;
                Card.Suit coul = carte_dessus.Color;
                while (nummax >= nummin)
                {
                    this.cards.Add(new Card(nummax, coul, true));
                    nummax--;
                }
            }
        }

        public override string Save()
        {
            StringBuilder repres = new StringBuilder("");
            if (!Empty)
            {
                repres.Append(First.Save());
                repres.Append(Last.Save());
            }
            return repres.ToString();
        }

        public override void Load(string cartes)
        {
            this.cards.Clear();
            if (cartes.Length == 4)
            {
                StringBuilder carte = new StringBuilder("");
                carte.Append(cartes[0]);
                carte.Append(cartes[1]);
                Card carte_dessus = Card.Load(carte.ToString());
                carte = new StringBuilder("");
                carte.Append(cartes[2]);
                carte.Append(cartes[3]);
                Card carte_dessous = Card.Load(carte.ToString());
                if ((carte_dessous.Figure.Value > carte_dessus.Figure.Value) || (carte_dessous.Color != carte_dessus.Color))
                {
                    throw new ArgumentException("Dans l’encodage, la valeur de la première carte doit être supérieure à celle de la seconde et les cartes doivent être de même couleur.");
                }
                int nummax = carte_dessus.Figure.Value;
                int nummin = carte_dessous.Figure.Value;
                Card.Suit coul = carte_dessus.Color;
                while (nummax >= nummin)
                {
                    this.cards.Add(new Card(nummax, coul, true));
                    nummax--;
                }
            }
        }
    }
}
