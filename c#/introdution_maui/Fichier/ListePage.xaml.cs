using Fichier.ViewModel;
using System.Windows.Input;

namespace Fichier;

public partial class ListePage : ContentPage
{
    public ICommand AddCommand { get; }
    private void AddCitation()
    {
        this.Navigation.PushAsync(new CitationPage(new VMCitation()));
    }
    public ListePage()
	{        
        AddCommand = new Command(AddCitation);
		InitializeComponent();
		LstCitations.ItemsSource = (Application.Current as App)?.Citations;

    }

    private void LstCitations_ItemTapped(object sender, ItemTappedEventArgs e)
    {
        if (e.Item.GetType() == typeof(VMCitation) )
        {
            this.Navigation.PushAsync(new CitationPage((VMCitation)e.Item));
        }
    }
}