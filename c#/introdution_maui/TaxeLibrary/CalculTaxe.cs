using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace TaxeLibrary
{
    public class CalculTaxe
    {
        private double taxe;
        public double Taxe
        {
            get { return taxe; }
            private set
            {
                if (value != taxe)
                {
                    taxe = value;
                }
            }
        }

        private double tauxtaxe;
        public double TauxTaxe
        {
            get { return tauxtaxe; }
            set
            {
                if (value != tauxtaxe)
                {
                    tauxtaxe = value;

                    PrixTTC = _PrixHT + _PrixHT * tauxtaxe;
                    Taxe = _PrixHT * tauxtaxe;
                }
            }
        }

        private double _PrixHT;
        public double PrixHT
        {
            get { return _PrixHT; }
            set
            {
                if (value != _PrixHT)
                {
                    _PrixHT = value;

                    Taxe = PrixHT * tauxtaxe;
                    PrixTTC = _PrixHT + _PrixHT * tauxtaxe;
                }
            }
        }

        private double _PrixTTC;
        public double PrixTTC
        {
            get { return _PrixTTC; }
            set
            {
                if (_PrixTTC != value)
                {
                    _PrixTTC = value;

                    Taxe = _PrixTTC * tauxtaxe / (1 + tauxtaxe);
                    PrixHT = _PrixTTC - taxe;
                }
            }
        }

        public CalculTaxe()
        {
            taxe = 0;

            this.Taxe = 0;

            TauxTaxe = 0.2;
        }
    }
}
