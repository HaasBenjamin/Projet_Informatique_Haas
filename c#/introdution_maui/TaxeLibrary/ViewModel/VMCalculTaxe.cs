using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Globalization;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Input;

namespace TaxeLibrary.ViewModel
{
    public class VMCalculTaxe : INotifyPropertyChanged
    {
        public VMCalculTaxe()
        { 
            SetTauxTaxe = new CommandTaxe(this);
        }
        private CalculTaxe _cTaxe = new CalculTaxe();
        public ICommand SetTauxTaxe { get; }
        
        private bool entreeTTC;
        public double TauxTaxe { get { return _cTaxe.TauxTaxe * 100; } set 
            {
                if ( TauxTaxe != value ) {
                    double pttc = _cTaxe.PrixTTC;
                    _cTaxe.TauxTaxe = value / 100;
                    if (EntréeTTC)
                    {
                        _cTaxe.PrixTTC = pttc;
                    }
                    NotifyPropertyChanged(nameof(TauxTaxeAffiché));
                    NotifyPropertyChanged(nameof(PrixAffiché));
                    NotifyPropertyChanged(nameof(Taxe));
                    NotifyPropertyChanged(nameof(TauxTaxe));
                }
            }
        }
        public string TauxTaxeAffiché { get { return string.Format("{0:F2} %", TauxTaxe); } }

        public bool EntréeTTC {
            get { return entreeTTC; }
            set { 
                if (value != entreeTTC)
                {
                    entreeTTC = value;
                    if ( !value)
                    {
                        _cTaxe.PrixHT = _cTaxe.PrixTTC;
                    }
                    else
                    {
                        _cTaxe.PrixTTC = _cTaxe.PrixHT;
                    }
                    
                    NotifyPropertyChanged(nameof(PrixAffiché));
                    NotifyPropertyChanged(nameof(Taxe));
                }
            }
        }

        public string PrixEntré { 
            get
            {
                if (EntréeTTC)
                {
                    return _cTaxe.PrixTTC==0.0 ? "" : Math.Round(_cTaxe.PrixTTC, 2).ToString();
                }
                return _cTaxe.PrixHT == 0.0 ? "" : Math.Round(_cTaxe.PrixHT, 2).ToString();
            }
            set
            {
                double nb;
                bool change = false;
                if (double.TryParse( value, out nb) )
                {
                    if (EntréeTTC)
                    {
                        if (_cTaxe.PrixTTC != nb)
                        {
                            _cTaxe.PrixTTC = nb;
                            change=true;
                        }

                    }
                    else
                    {
                        if (_cTaxe.PrixHT != nb)
                        {
                            _cTaxe.PrixHT = nb;
                            change = true;
                        }
                    }
                    if (change)
                    {
                        NotifyPropertyChanged(nameof(PrixAffiché));
                        NotifyPropertyChanged(nameof(Taxe));
                        NotifyPropertyChanged(nameof(PrixEntré));

                    }
                }
                else
                {
                    _cTaxe.PrixTTC = 0.0;
                }
            }
        }

        public event PropertyChangedEventHandler? PropertyChanged;

        private void NotifyPropertyChanged([CallerMemberName] string member = "")
        {
            PropertyChanged ?.Invoke(this, new PropertyChangedEventArgs(member));
        }

        public string PrixAffiché { get 
            { 
                return (CultureInfo.CurrentCulture.IetfLanguageTag == new CultureInfo("fr-FR").IetfLanguageTag) ? string.Format("{0:F2} €", _cTaxe.PrixTTC) : string.Format("${0:F2}", _cTaxe.PrixTTC);
            } 
        }

        public string Taxe
        {
            get
            {
                return (CultureInfo.CurrentCulture.IetfLanguageTag == new CultureInfo("fr-FR").IetfLanguageTag) ? string.Format("{0:F2} €", _cTaxe.Taxe) : string.Format("${0:F2}", _cTaxe.Taxe);

            }
        }
    }
}
