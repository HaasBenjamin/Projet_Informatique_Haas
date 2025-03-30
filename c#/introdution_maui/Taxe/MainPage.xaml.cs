using TaxeLibrary.ViewModel;

namespace Taxe
{
    public partial class MainPage : ContentPage
    {
        int count = 0;

        public MainPage()
        {
            InitializeComponent();
            BindingContext = new VMCalculTaxe();
        }

       

    }

}
