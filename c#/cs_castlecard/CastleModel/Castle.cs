using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml.Serialization;
using System.Xml;
using System.IO;

namespace CastleModel
{
    public class Castle
    {
        private List<Heap> heaps;
        private List<BaseHeap> baseHeaps;
        private List<Column> columns;
        private List<Deck> deck;
        private Stack<Move> moves = new Stack<Move>();

        public List<Heap> Heaps
        {
            get { return heaps; }
        }
        public List<Column> Column
        {
            get { return columns; }
        }
        public List<Deck> Deck
        {
            get { return deck; }
        }
        public List<BaseHeap> BaseHeaps
        {
            get { return baseHeaps; }
        }

        public bool Finished
        {
            get
            {
                bool finished = true;
                foreach (BaseHeap baseh in this.baseHeaps)
                {
                    if (baseh.Count != 13)
                    {
                        finished = false;
                    }
                }
                return finished;
            }
        }

        public Castle()
        {
            List<Heap> heaps_tmp = new List<Heap>();
            for(int i = 1; i < 4; i++)
            {
                heaps_tmp.Add(new Heap(i));
            }
            heaps=heaps_tmp;
            List<BaseHeap> baseHeap_tmp = new List<BaseHeap>();
            for (int i = 1; i < 5; i++)
            {
                baseHeap_tmp.Add(new BaseHeap(i));
            }
            baseHeaps = baseHeap_tmp;
            List<Deck> deck_tmp = new List<Deck>();
            deck_tmp.Add(new Deck(heaps_tmp[0], heaps_tmp[1], heaps_tmp[2]));
            deck = deck_tmp;
            List<Column> column_tmp = new List<Column>();
            for (int i = 1; i < 7; i++)
            {
                column_tmp.Add(new Column(i));
            }
            

            columns = column_tmp;
        }

        public void Distribute()
        {
            List<Card> jeu = new List<Card>();
            for (int j = 2; j < 14; j++)
            {
                jeu.Add(new Card(new Card.Face(j), Card.Suit.CLUB, false));
                jeu.Add(new Card(new Card.Face(j), Card.Suit.SPADE, false));
                jeu.Add(new Card(new Card.Face(j), Card.Suit.DIAMOND, false));
                jeu.Add(new Card(new Card.Face(j), Card.Suit.HEART, false));
            }
            foreach (Heap heap in heaps)
            {
                heap.Clear();
            }

            foreach (Column column in columns)
            {
                column.Clear();
                Random random = new Random();
                int ind = random.Next(jeu.Count);
                Card carte = jeu[ind];
                carte.Visible = true;
                column.Push(carte);
                jeu.RemoveAt(ind);
            }
            List<Card> cards = new List<Card>();
            cards.Add(new Card(new Card.Face("A"), Card.Suit.CLUB, true));
            cards.Add(new Card(new Card.Face("A"), Card.Suit.SPADE, true));
            cards.Add(new Card(new Card.Face("A"), Card.Suit.DIAMOND, true));
            cards.Add(new Card(new Card.Face("A"), Card.Suit.HEART, true));
            int i = 0;
            foreach (BaseHeap baseHeap in baseHeaps)
            {
                baseHeap.Clear();
                baseHeap.Push(cards[i]);
                i++;
            }
            deck[0].Clear();
            while (0 < jeu.Count)
            {
                Random random = new Random();
                int ind = random.Next(jeu.Count);             
                deck[0].Push(jeu[ind]);
                jeu.RemoveAt(ind);
            }


        }

        public Pile GetPile(Move.Pile pile)
        {
            Move.PileName pilename = pile.Name;
            switch (pilename)
            {
                case Move.PileName.COLUMN:
                    foreach(Column column in Column)
                    {
                        if (column.Number == pile.Number)
                        {
                            return column;
                        }
                    }
                    break;
                case Move.PileName.DECK:
                    foreach (Deck dec in Deck)
                    {
                        if (dec.Number == pile.Number)
                        {
                            return dec;
                        }
                    }
                    break;
                case Move.PileName.HEAP:
                    foreach (Heap hea in Heaps)
                    {
                        if (hea.Number == pile.Number)
                        {
                            return hea;
                        }
                    }
                    break;
                case Move.PileName.BASEHEAP:
                    foreach (BaseHeap bas in BaseHeaps)
                    {
                        if (bas.Number == pile.Number)
                        {
                            return bas;
                        }
                    }
                    break;
            }
            throw new ArgumentException($"Le numéro de pile {pile.Number} n’existe pas pour la pile {pilename}");
        }

        public int? GetColumnFor(Card carte , bool allowEmptyColumn)
        {
            foreach (Column column in Column)
            {
                if (column.Empty)
                {
                    if (allowEmptyColumn)
                    {
                        return column.Number;
                    }
                }
                else
                {
                    if (column.CanPush(carte))
                    {
                        return column.Number;
                    }
                }
            }
            return null;
        }

        public int? GetBaseHeapFor(Card carte)
        {
            int res = (from b in baseHeaps where b.CanPush(carte) select b.Number).FirstOrDefault();
            return res == 0 ? null : res;

        }

        public void ApplyMove(Move move)
        {
            Pile pile = GetPile(move.From);
            pile.ApplyMove(this, move);
            moves.Push(move);
        }

        public void ApplyMove(string chaine)
        {
            Move move = new Move(chaine,this);
            ApplyMove(move);
        }

        public Move? SearchMoveToBaseHeap()
        {
            foreach(BaseHeap baseh in this.baseHeaps)
            {
                foreach (Heap heap in this.Heaps)
                {
                    if (!heap.Empty && baseh.CanPush(heap.Last))
                    {
                        return new Move(heap, baseh);
                    }
                }

                foreach (Column column in this.Column)
                {
                    if (!column.Empty && baseh.CanPush(column.Last))
                    {
                        return new Move(column, baseh);
                    }
                }

            }
            return null ;
        }

        public Pile? SearchPileForCard(Card? carte)
        {
            if (carte == null)
            {
                throw new ArgumentException("Aucune carte à déplacer");
            }

            foreach (BaseHeap baseh in this.baseHeaps)
            {
                if (baseh.CanPush(carte))
                {
                    return baseh;
                }
            }

            foreach (Column column in this.Column)
            {
                if (!column.Empty && column.CanPush(carte))
                {
                    return column;
                }
            }
            foreach (Column column in this.Column)
            {
                if (column.Empty)
                {
                    return column;
                }
            }
            return null;
        }

        public Move? UndoMove()
        {
            if (this.moves.Count == 0)
            {
                return null;
            }
            Move? undo = moves.Pop();
            Pile? source = null;
            try
            {
                source = this.GetPile(undo.From);
            }
            catch (ArgumentException) {};
            
            if (source != null)
            {
                try
                {
                    Pile? dest = null;
                    if (undo.To != null)
                    {
                        dest = this.GetPile(undo.To);
                    }
                    
                    source.UndoMove(dest,undo.CardsCount);
                }
                catch (Exception) {
                };



            }
            return undo;
        }
        
        public Move? SearchMoveColumnToColumn()
        {
            foreach (Column column in this.Column)
            {
                if (!column.Empty)
                {
                    Card card = column.First;
                    foreach (Column column1 in this.Column)
                    {
                        if (!column1.Empty && column1.CanPush(card))
                        {
                            return new Move(column, column1);
                        }
                    }

                }
            }
            return null;
        }

        public Move? SearchMoveHeapToNonEmptyColumn()
        {
            foreach(Heap heap in this.Heaps)
            {
                if (!heap.Empty)
                {
                    int? col = GetColumnFor(heap.Last, false);
                    if (col != null)
                    {
                        Move.Pile colonne = new Move.Pile();
                        colonne.Number = col;
                        colonne.Name = Move.PileName.COLUMN;
                        Pile pile = GetPile(colonne);
                        return new Move(heap, pile);
                    }
                }
            }
            return null;
        }

        public List<Move> SearchMovesFromHeapToEmptyColumn()
        {
            Column col = null;
            foreach (Column column in this.Column)
            {
                if (column.Empty)
                {
                    col = column;
                    break;
                }
            }
            List<Move> listMove = new List<Move>();
            if (col!= null)
            {
                foreach (Heap heap in this.Heaps)
                {
                    if (!heap.Empty)
                    {
                        listMove.Add(new Move(heap,col));
                    }
                   
                }
            }

            return listMove;
        }

        public List<Move> SearchAllMoves()
        {
            List<Move> listMove = new List<Move>();
            Move? move = SearchMoveToBaseHeap();
            if (move != null)
            {
                listMove.Add(move);
                return listMove;
            }
            move = SearchMoveColumnToColumn();
            if (move != null)
            {
                listMove.Add(move);
                return listMove;
            }
            move = SearchMoveHeapToNonEmptyColumn();
            if (move != null)
            {
                listMove.Add(move);
                return listMove;
            }
            listMove = SearchMovesFromHeapToEmptyColumn();
            listMove.Add(new Move(deck[0],null));
            return listMove;
        }

        public string Encode()
        {
            StringBuilder repres = new StringBuilder("");
            foreach(BaseHeap baseheap in this.baseHeaps) 
            {
                repres.Append(baseheap.Encode());
                repres.Append(" ");   
            }
            List<string> L = new List<string>();
            List<string> L2 = new List<string>();
            foreach (Column c in columns)
            {
                L.Add(c.Encode());
            }
            L.Sort();
            L.Reverse();
            int i = 0;
            while (i < L.Count)
            {
                L2.Add(L[i]);
                L2.Add(" ");
                i ++;
            }

            string test = string.Join(string.Empty, L2);
            repres.Append(test);
            foreach (Heap heap in this.heaps)
            {
                repres.Append(heap.Encode());
                repres.Append(" ");
            }
            foreach (Deck dec in this.deck)
            {
                repres.Append(dec.Encode());
                repres.Append(" ");
            }
            repres.Remove(repres.Length-1,1);
            return repres.ToString();
        }

        public void Decode(string repres)
        {
            int empl = 0;
            string[] chars = repres.Split(" ");
            try
            {

                foreach (BaseHeap baseheap in this.baseHeaps)
                {
                    baseheap.Decode(chars[empl]);
                    empl++;
                }

                foreach (Column c in columns)
                {
                    c.Decode(chars[empl]);
                    empl++;
                }

                foreach (Heap heap in this.heaps)
                {
                    heap.Decode(chars[empl]);
                    empl++;
                }
                foreach (Deck dec in this.deck)
                {
                    dec.Decode(chars[empl]);
                    empl++;
                }
            }catch (Exception e)
            {
                throw new ArgumentException("Une erreur s'est produite lors de la reconstruction du jeu");
            }
        }

        public void Save(string filename)
        {
            StringBuilder repres = new StringBuilder("");
            foreach (BaseHeap baseheap in this.baseHeaps)
            {
                repres.Append(baseheap.Save());
                repres.Append(" ");
            }
            List<string> L = new List<string>();
            List<string> L2 = new List<string>();
            foreach (Column c in columns)
            {
                L.Add(c.Save());
            }
            L.Sort();
            L.Reverse();
            int i = 0;
            while (i < L.Count)
            {
                L2.Add(L[i]);
                L2.Add(" ");
                i++;
            }

            string test = string.Join(string.Empty, L2);
            repres.Append(test);
            foreach (Heap heap in this.heaps)
            {
                repres.Append(heap.Save());
                repres.Append(" ");
            }
            repres.Remove(repres.Length - 1, 1);
            string represFinal = repres.ToString();
            FileStream writeFileStream = null;
            Directory.CreateDirectory("C:\\tmp\\castleCard\\save");
            string emplacement = Path.Combine("C:\\tmp\\castleCard\\save", filename);
            if (File.Exists(emplacement))
            {
                writeFileStream = new FileStream(emplacement + ".txt",
               FileMode.Truncate);
            }
            else
            {
                writeFileStream = new FileStream(emplacement + ".txt",
               FileMode.Create);
            }
            using (writeFileStream)
            {
                writeFileStream.Write(new UTF8Encoding(true).GetBytes(represFinal));
                writeFileStream.Flush();
            }

        }

        public void Load(string filename)
        {
            StringBuilder repres = new StringBuilder("");
            string emplacement = Path.Combine("C:\\tmp\\castleCard\\save", filename+".txt");
            using (FileStream fs = File.OpenRead(emplacement))
            {
                byte[] b = new byte[1024];
                UTF8Encoding temp = new UTF8Encoding(true);
                int readLen;
                while ((readLen = fs.Read(b, 0, b.Length)) > 0)
                {
                    repres.Append(temp.GetString(b, 0, readLen));
                }
            }
            List<Card> jeu = new List<Card>();
            for (int j = 1; j < 14; j++)
            {
                jeu.Add(new Card(new Card.Face(j), Card.Suit.CLUB, false));
                jeu.Add(new Card(new Card.Face(j), Card.Suit.SPADE, false));
                jeu.Add(new Card(new Card.Face(j), Card.Suit.DIAMOND, false));
                jeu.Add(new Card(new Card.Face(j), Card.Suit.HEART, false));
            }
            int empl = 0;
            string[] chars = repres.ToString().Split(" ");
            foreach (BaseHeap baseheap in this.baseHeaps)
            {
                baseheap.Load(chars[empl]);
                empl++;
                foreach (Card card in baseheap)
                {
                    jeu.Remove(card);
                }
            }

            foreach (Column c in columns)
            {
                c.Load(chars[empl]);
                empl++;
                foreach (Card card in c)
                {
                    jeu.Remove(card);
                }
            }

            foreach (Heap heap in this.heaps)
            {
                heap.Load(chars[empl]);
                empl++;
                foreach (Card card in heap)
                {
                    jeu.Remove(card);
                }
            }
            deck[0].Clear();
            while (0 < jeu.Count)
            {
                Random random = new Random();
                int ind = random.Next(jeu.Count);
                deck[0].Push(jeu[ind]);
                jeu.RemoveAt(ind);
            }

        }
    }

}
