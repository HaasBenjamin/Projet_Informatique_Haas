using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using WPF_Castle.View;

namespace WPF_Castle.ViewModel
{
    public class VMBaseHeap : VMStack
    {
        public VMBaseHeap(Pile pile, VMCastle castle) : base(pile, castle) { }

        public override void DropOnView(VMStack from, ViewCard card)
        {
            if (from.Column.GetType() == typeof(Column)) 
            {
                this.viewStack.MoveCardsFrom(from.ViewStack, null, true);
            }
            else
            {
                base.DropOnView(from, card);
            }
        }
    }
}
