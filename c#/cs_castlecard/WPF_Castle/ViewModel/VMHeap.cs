using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace WPF_Castle.ViewModel
{
    public class VMHeap : VMStack
    {
        public VMHeap(Pile pile, VMCastle castle) : base(pile, castle) { }
        public override bool canDrag(int indice)
        {
            return true;
        }
    }
}
