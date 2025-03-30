using System.Data;
using System.Reflection.Metadata;

namespace CalculatriceLibrary
{
    public class Calculatrice
    {
        private Dictionary<Operation,string> operations;
        public enum Operation
        {
            ADDITIONNER,
            SOUSTRAIRE,
            MULTIPLIER,
            DIVISER
        }
        public string Operations { get; private set; }
        public double Resultat { get; private set; }

        private bool _operateur = false;
        private bool _unique_0 = true;

        public bool AddDigit(int digit)
        {
            if (digit < 0 || digit > 9)
            {
                throw new ArgumentOutOfRangeException($"Calculatrice.AddDigit : Le paramètre {digit} doit être compris entre 0 et 9");
            }
            if (digit == 0)
            {
                if (_operateur)
                {
                    Operations += "0";
                    _unique_0 = true;
                }
                else if (_unique_0)
                {
                    return false;
                }
                else
                {
                    Operations += "0";
                }
            } 
            else
            {
                if (_unique_0)
                {
                    Operations = Operations.Remove(Operations.Length - 1);
                    Operations += digit.ToString();
                }
                else
                {
                    Operations += digit.ToString();
                }
                _unique_0 = false;
            }
            _operateur = false;
            DataTable res = new DataTable();
            object calcul = res.Compute(Operations,null);
            Resultat = double.Parse(calcul.ToString());
            return true;
        }

        public void AddOperateur( Operation operateur) 
        {
            this._unique_0 = false;
            if (_operateur)
            {
                Operations = Operations.Remove(Operations.Length - 1);
            }
            Operations += this.operations[operateur];
            this._operateur = true;
        }

        public void Reset()
        {
            this.Operations = "0";
            this.Resultat = 0.0;
            this._operateur = false;
            this._unique_0 = true;
        }

        public Calculatrice()
        {
            operations = new Dictionary<Operation,string>();
            operations.Add(Operation.ADDITIONNER, "+");
            operations.Add(Operation.SOUSTRAIRE, "-");
            operations.Add(Operation.MULTIPLIER, "*");
            operations.Add(Operation.DIVISER, "/");
            this.Operations = "0";
            this.Resultat = 0.0;
        }

        public void Compute()
        {
            Operations = Resultat.ToString().Replace(',', '.');
            if (Resultat == 0.0)
            {
                _unique_0 = true;
            }
        }
    }
}
