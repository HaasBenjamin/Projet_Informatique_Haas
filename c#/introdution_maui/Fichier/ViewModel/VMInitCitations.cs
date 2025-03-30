using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Input;

namespace Fichier.ViewModel
{
    public class VMInitCitations : INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler? PropertyChanged;
        private void NotifyPropertyChanged([CallerMemberName] string prop = "")
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(prop));
        }

        private MainPage? mainPage = null;
        private IList<VMCitation>? liste = null;
        public ICommand DisplayCommand { get; }

        public VMInitCitations() 
        {
            DisplayCommand = new Command(DisplayListePage, CanDisplayListePage);
        }

        public string Count { 
            get 
            { 
                if (liste == null)
                {
                    return "???";
                }
                return liste.Count.ToString();
            } 
        }
        public string ButtonText {
            get
            {
                if (liste == null)
                {
                    return "Chargement des citations en cours…";
                }
                return "Afficher les citations";
            }
        }

       private void DisplayListePage()
        {
            if (mainPage != null)
            {
                mainPage.DisplayListePage();
            }
        }

        private bool CanDisplayListePage()
        {
            return liste != null;
        }

        public void Init(MainPage mainP)
        {
             this.mainPage = mainP;
            //Task.Run(() =>
            //{
                this.liste = (Application.Current as App).Citations;
                NotifyPropertyChanged(nameof(Count));
                NotifyPropertyChanged(nameof(ButtonText));
                this.mainPage.Dispatcher.Dispatch(() =>
                {
                    (DisplayCommand as Command)?.ChangeCanExecute();
                });
            //     mainPage.EnableButton();
            //});

        }

    }
}
