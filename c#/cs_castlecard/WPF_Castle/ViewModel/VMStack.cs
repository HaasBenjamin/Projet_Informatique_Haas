using CastleModel;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using WPF_Castle.View;

namespace WPF_Castle.ViewModel
{
    public class VMStack
    {
        protected Pile column;
        private VMCastle vmCastle;
        protected ViewStack viewStack;

        public ViewStack ViewStack
        {
            get { return viewStack; }
            set { viewStack = value; }
        }

        public Pile Column { get { return column; } }
        public bool CanPush (Card card)
        {
            return column.CanPush(card);
        }
        
        public VMCastle VMCastle { get { return vmCastle; }  }
        public VMStack(Pile pile, VMCastle castle)
        {
            column = pile;
            vmCastle = castle;
        }

        public ViewStack CreateViewStack(ViewCanvas viewCanvas)
        {
            this.viewStack = new ViewStack(viewCanvas,this);
            foreach (Card card in column)
            {
                VMCard vmc = new VMCard(card);
                this.viewStack.AddCard(new ViewCard(vmc));
            }
            return this.viewStack;  
        }

        public bool Drop(VMStack from, ViewCard card)
        {
            return vmCastle.Drop(from,this,card);
        }

        public virtual void DropOnView(VMStack from, ViewCard card)
        {

            viewStack.MoveCardsFrom(from.ViewStack, card);
        }

        public virtual void ApplyMove(VMStack to)
        {

        }

        public void OnClick()
        {
            vmCastle.ApplyMove(this);
        }

        public virtual bool canDrag(int idx) {  return false; }
    }
}
