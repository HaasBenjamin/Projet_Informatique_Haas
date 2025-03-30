using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Input;

namespace TaxeLibrary.ViewModel
{
    public class CommandTaxe : ICommand
    {
        private VMCalculTaxe _vmCalculTaxe;
        public CommandTaxe(VMCalculTaxe calculTaxe)
        {
            _vmCalculTaxe = calculTaxe;
        }

        public event EventHandler? CanExecuteChanged;

        public bool CanExecute(object? parameter)
        {
            return true;
        }

        public void Execute(object? parameter)
        {
            double taux;
            if (parameter.GetType() == typeof(string) && (double.TryParse((string?)parameter, out taux)))
            {
                _vmCalculTaxe.TauxTaxe = taux;
            }
        }
    }
}
