using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using WPF_Castle.View;

namespace WPF_Castle.ViewModel
{
    public class VMDeck:VMStack
    {
        public VMDeck(Pile pile, VMCastle castle) : base(pile,castle) { }

        public Pile Column { get { return this.column; } }
        public ViewStack ViewStack { get { return this.viewStack; } }

        public VMStack[] Heaps { get;set; }

        public override void ApplyMove(VMStack to)
        {
            foreach (VMStack heap in this.Heaps)
            {
                heap.ViewStack.MoveCardsFrom(ViewStack);
                heap.ViewStack.RefreshCards(heap.ViewStack.Count-1);
            }

            ViewStack.RefreshCards(ViewStack.Count-1);
        }
    }
}
