using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.RightsManagement;
using System.Text;
using System.Threading.Tasks;
using WPF_Castle.View;

namespace WPF_Castle.ViewModel
{
    public class VMCastle
    {
        private readonly Castle game;
        private readonly VMStack[] heaps = new VMStack[3];
        private readonly VMStack[] basesHeap = new VMStack[4];
        private readonly VMDeck deck;
        private readonly VMStack[] columns = new VMStack[6];

        public VMStack[] Heaps { get { return heaps; } }
        public VMStack[] BasesHeap { get { return basesHeap; } }
        public VMDeck Deck { get { return deck; } }
        public VMStack[] Columns { get { return columns; } }

        public VMCastle(Castle? castle = null)
        {
            castle.Distribute();
            this.game = castle;
            int i = 0;
            foreach(Column col in castle.Column)
            {
                columns[i] = new VMColumn(col,this);
                i++;
            }
            i = 0;
            foreach(BaseHeap bh in castle.BaseHeaps)
            {
                basesHeap[i] = new VMBaseHeap(bh, this);
                i++;
            }
            i = 0;
            foreach(Heap heap in castle.Heaps)
            {
                heaps[i] = new VMHeap(heap, this);
                i++;
            }
            deck = new VMDeck(castle.Deck[0], this);
            deck.Heaps = this.heaps;
        }

        public bool Drop(VMStack from, VMStack to, ViewCard card)
        {
            if (to.CanPush(card.VmCard.Card))
            {
                try
                {
                    Move move = new Move(from.Column, to.Column);
                    game.ApplyMove(move);
                    to.DropOnView(from, card);
                    game.Afficher(move);
                    return true;
                }catch(Exception e)
                {
                    game.Afficher();
                    return false;
                }
                
            }
            game.Afficher();
            return false;
        }

        public VMStack? GetCorrespondingStack(Move.Pile? pile)
        {
            if (pile == null)
            {
                return null;
            }
            return new VMStack(game.GetPile(pile), this);
        }


        private static int nbmove = 0;
        public void ApplyMove(VMStack stack)
        {
            try
            {
                Move move = new Move(stack.Column, null);
                game.ApplyMove(move);
                VMStack? corresp = GetCorrespondingStack(move.To);
                stack.ApplyMove(corresp);
                Console.WriteLine($"Move {nbmove} : {move.ToString()}");
                
            }
            catch (Exception e) { }
            
        }
    }
}
