using Fichier.ViewModel;

namespace Fichier
{
    public partial class App : Application
    {
        private readonly VMListCitations vmListe = new VMListCitations(FileSystem.AppDataDirectory);
        
        public IList<VMCitation>? Citations { get { return  vmListe.Citations; } }
        public VMListCitations Liste { get { return vmListe; } }
        public App()
        {
            InitializeComponent();

            MainPage = new NavigationPage(new MainPage());
        }

        protected async override void OnStart()
        {
          //   await vmListe.Load();
        }
        
    }
}
