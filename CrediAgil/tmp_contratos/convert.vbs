Set objWord = CreateObject("Word.Application")
objWord.Visible = False
Set objDoc = objWord.Documents.Open(WScript.Arguments(0))
objDoc.SaveAs WScript.Arguments(1), 17
objDoc.Close
objWord.Quit
