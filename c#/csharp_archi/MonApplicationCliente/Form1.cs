using System.Windows.Forms;

namespace MonApplicationCliente
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {

        }

        private async void search(object sender, EventArgs e)
        {
            HttpClient client = new HttpClient();
            client.BaseAddress = new Uri("https://localhost:7096");
            HttpResponseMessage messageretour = await client.GetAsync("Home" + urlbox.Text);
            if (messageretour.IsSuccessStatusCode) 
            {
                result.Text = result.Text + Environment.NewLine + " >> " + messageretour.ToString();
                result.Text = result.Text + Environment.NewLine + " >> " + await messageretour.Content.ReadAsStringAsync();
            }
            else
            {
                result.Text = result.Text + Environment.NewLine + " >> " + messageretour.ToString();
            }
        }
    }
}
