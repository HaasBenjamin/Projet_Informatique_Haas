using Fichier.Model;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Fichier.ViewModel
{
    public class VMListCitations
    {
        private const string FILENAME = "citations.json";
        private readonly string filenamePath;
        private readonly ListCitations listCitations = new ListCitations();
        private ObservableCollection<VMCitation>? vmList = null;

        public IList<VMCitation>? Citations { get
            {
                if (vmList == null)
                {
                    LoadStart() ;
                }
                return vmList;
            } }

        public VMListCitations(string filepath)
        {
            this.filenamePath = Path.Combine(filepath, FILENAME); 
        }

        public void Add(VMCitation vmcitation)
        {
            vmList.Add(vmcitation);
            listCitations.Citations.Add(vmcitation.Citation);
        }

        public void Save()
        {
            File.WriteAllText(filenamePath,listCitations.SaveToJson());
        }

        public  void LoadStart() 
        {
             Load();
            vmList = new ObservableCollection<VMCitation>();
            foreach (Citation citation in listCitations.Citations)
            {
                vmList.Add(new VMCitation(citation));
            }
        }

        public async Task Load()
        {
            if (File.Exists(filenamePath)) 
            {
              //   using Stream fileStream = await FileSystem.Current.OpenAppPackageFileAsync(filenamePath);
                using Stream fileStream = File.OpenRead(filenamePath);
                using StreamReader reader = new StreamReader(fileStream);
                string citations =  reader.ReadToEnd();
                listCitations.LoadFromJson(citations);
            }
        }

        public void Remove(VMCitation citation)
        {
            vmList?.Remove(citation);
            listCitations.Citations.Remove(citation.Citation);
        }
    }
}
