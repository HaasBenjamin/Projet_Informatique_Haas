using Fichier.Model;
using Fichier.ViewModel;
using System.ComponentModel;
using System.Windows.Input;

namespace Fichier;

public partial class CitationPage : ContentPage
{
	private readonly VMCitation citation;
	private readonly VMCitation? backup;
	public VMCitation Citation { get { return citation; } }
	public ICommand SaveCommand { get; }
	public ICommand CancelCommand { get; }
	public ICommand DeleteCommand { get; }

	public CitationPage(VMCitation vMCitation = null)
	{
        SaveCommand = new Command(Save,CanSave);
		CancelCommand = new Command(Cancel, CanCancel);
		DeleteCommand = new Command(Delete, CanDelete);
		if(!(vMCitation.Auteur == null))
		{
			citation = vMCitation;
			backup = new VMCitation(new Citation(vMCitation.Citation.Auteur, vMCitation.Citation.Texte));
		}
		else
		{
			citation = new VMCitation();
			backup = null;
		}
        this.citation.PropertyChanged += CitationModified;	

		
		InitializeComponent();
		

		
		
	// 	BindingContext = this;
    }
    protected override bool OnBackButtonPressed()
    {
        Dispatcher.Dispatch(async () =>
        {
			if (CanCancel())
			{
				if (await DisplayAlert( "Confirmation", "Confirmer votre sortie","Confirmer", "Annuler" ))
				{
					Cancel();
					// Confirmation de la sortie de la page
					await Navigation.PopAsync();
				}
			}
			
        });
        // Annuler le retour en arrière (sortie de la page)
        return true;
    }


    private void Save()
	{
        VMListCitations? liste = (Application.Current as App)?.Liste;
		if (backup == null)
		{
            liste.Add(citation);
        }
        liste.Save();
        Navigation.PopAsync();
    }

    private void Cancel()
	{
		if (backup != null)
		{
			citation.Auteur = backup.Auteur;
			citation.Texte = backup.Texte;
			Navigation.PopAsync();
        }
	}

	private void Delete()
	{
        (Application.Current as App)?.Liste.Remove(citation);
		this.Save();

    }

	private bool CanSave()
	{
		if (backup == null)
		{
			return true;
		}
		return (citation.Citation.Texte != backup.Citation.Texte || citation.Citation.Auteur != backup.Citation.Auteur);
	}
    private bool CanCancel()
    {
        return (backup != null) && (citation.Citation.Texte != backup.Citation.Texte || citation.Citation.Auteur != backup.Citation.Auteur);
    }
    private bool CanDelete()
    {
        return true;
    }

	private void CitationModified(object? sender, PropertyChangedEventArgs e)
	{
        (SaveCommand as Command)?.ChangeCanExecute();
        (CancelCommand as Command)?.ChangeCanExecute();
        (DeleteCommand as Command)?.ChangeCanExecute();
    }
}