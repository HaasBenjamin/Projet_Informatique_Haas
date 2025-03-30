using System.ComponentModel;
using System.Runtime.CompilerServices;
using System.Windows.Input;
using Calc = CalculatriceLibrary.Calculatrice;
using Prism.Commands;
using System.Globalization;

namespace Calculatrice.ViewModel
{
    public class VMCalculatrice : INotifyPropertyChanged
    {
        private Calc _calculatrice;

        public event PropertyChangedEventHandler? PropertyChanged;

        public double Resultat { get { return _calculatrice.Resultat; } }
        public string Operations { get { return _calculatrice.Operations; } }

        public ICommand AddDigitCommand { get; set; }
        public ICommand AddOperatorCommand { get; set; }
        public ICommand ResetCommand { get; set; }
        public ICommand ComputeCommand { get; set; }

        private void NotifyPropertyChanged([CallerMemberName] string prop = "")
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(prop));
        }

        public void AddDigit(int digit)
        {
            if (_calculatrice.AddDigit(digit))
            {
                NotifyPropertyChanged(nameof(Operations));
                NotifyPropertyChanged(nameof(Resultat));
            }
        }

        public void AddOperateur(string @operator)
        {
            Calc.Operation op = Calc.Operation.ADDITIONNER;
            switch (@operator)
            {
                case "-":
                    op = Calc.Operation.SOUSTRAIRE;
                    break;
                case "*":
                    op = Calc.Operation.MULTIPLIER;
                    break;
                case "/":
                    op = Calc.Operation.DIVISER;
                    break;
            }
            _calculatrice.AddOperateur(op);
            NotifyPropertyChanged(nameof(Operations));
        }

        public void Reset()
        {
            _calculatrice.Reset();
            NotifyPropertyChanged(nameof(Operations));
            NotifyPropertyChanged(nameof(Resultat));
        }
        public void Compute()
        {
            _calculatrice.Compute();
            NotifyPropertyChanged(nameof(Operations));
        }


        public VMCalculatrice()
        {
            _calculatrice = new Calc();
            AddDigitCommand = new Command<int>(AddDigit);
            AddOperatorCommand = new Command<string>(AddOperateur);
            ResetCommand = new Command(Reset);
            ComputeCommand = new Command(Compute);
        }

    }
    public class ConvertStringToInt : IValueConverter
    {
        public object? Convert(object? value, Type targetType, object? parameter, CultureInfo culture)
        {
            if (value is string str && int.TryParse(str, culture, out int res))
            {
                return res;
            }
            return null;
        }
        public object? ConvertBack(object? value, Type targetType, object? parameter, CultureInfo culture)
        {
            if (value is int res)
            {
                return res.ToString(culture);
            }
            return null;
        }
    }
}
