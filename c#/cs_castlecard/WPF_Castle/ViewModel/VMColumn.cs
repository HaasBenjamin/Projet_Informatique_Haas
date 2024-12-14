using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Documents;

namespace WPF_Castle.ViewModel
{
    public class VMColumn : VMStack
    {
        public VMColumn(Pile pile, VMCastle castle) : base(pile, castle) { }
        public override bool canDrag(int indice)
        {
            if (indice == 0 || indice == this.column.Count - 1)
            {
                return true;
            }
            return false;
        }
    }
}
