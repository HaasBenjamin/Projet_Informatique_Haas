namespace MonApplicationCliente
{
    partial class Form1
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            urlbox = new TextBox();
            buttonSend = new Button();
            result = new TextBox();
            SuspendLayout();
            // 
            // urlbox
            // 
            urlbox.Location = new Point(23, 12);
            urlbox.Name = "urlbox";
            urlbox.Size = new Size(100, 23);
            urlbox.TabIndex = 0;
            urlbox.Text = "Saisir URL";
            // 
            // buttonSend
            // 
            buttonSend.Location = new Point(149, 12);
            buttonSend.Name = "buttonSend";
            buttonSend.Size = new Size(75, 23);
            buttonSend.TabIndex = 1;
            buttonSend.Text = "Rechercher";
            buttonSend.UseVisualStyleBackColor = true;
            buttonSend.Click += search;
            // 
            // result
            // 
            result.Enabled = false;
            result.Location = new Point(23, 75);
            result.Multiline = true;
            result.Name = "result";
            result.Size = new Size(334, 259);
            result.TabIndex = 2;
            // 
            // Form1
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(402, 450);
            Controls.Add(result);
            Controls.Add(buttonSend);
            Controls.Add(urlbox);
            Name = "Form1";
            Text = "Form1";
            Load += Form1_Load;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private TextBox urlbox;
        private Button buttonSend;
        private TextBox result;
    }
}
