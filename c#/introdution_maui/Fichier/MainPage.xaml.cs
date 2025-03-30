using Fichier.ViewModel;

namespace Fichier
{
    public partial class MainPage : ContentPage
    {
        int count = 0;

        public MainPage()
        {
            InitializeComponent();
        }

        protected async override void OnAppearing()
        {
            initCitations.Init(this);
        }

        //public void EnableButton()
        //{
        //    BtnDisplay.IsEnabled = initCitations.Count != "???";
        //}



        public async void DisplayListePage()
        {
            await this.Navigation.PushAsync(new ListePage());

        }
    }

}
