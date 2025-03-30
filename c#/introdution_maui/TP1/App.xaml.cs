using System.Collections.ObjectModel;

namespace TP1
{
    public partial class App : Application
    {
        public App()
        {
            InitializeComponent();
            NumérosAppelés = new ObservableCollection<string>();
            MainPage = new AppShell();
        }
        public static ObservableCollection<string> NumérosAppelés { get; set; }
        public static string NUMEROS_TELEPHONE = "NUM_APPELES";

        protected override void OnSleep()
        {
            Preferences.Default.Set(NUMEROS_TELEPHONE, String.Join(";", NumérosAppelés));
        }

        protected override void OnStart() 
        {
            if (Preferences.Default.ContainsKey(NUMEROS_TELEPHONE))
            {
                string[] num = Preferences.Default.Get(NUMEROS_TELEPHONE,"").Split(';');
                foreach (string tel in num) 
                {
                    NumérosAppelés.Add(tel);
                }

            }
            
        }


    }
}
