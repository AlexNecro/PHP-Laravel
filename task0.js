function fact(n) {
    if (n == 1) 
        return n;
    else
        return fact(n - 1) * n;
}

function NumberExtractor(string, separator)
{
    this.string = string;
    this.separator = separator;
    this.length = string.length;
    this.pos = 0;

    this.isEmpty = function() {

        return !(this.pos < this.length);

    }

    this.getNext = function() {

        var number = 0;

        while (this.pos < this.length) {
            var c = this.string.charAt(this.pos);
            this.pos++;
            if (c == this.separator) {
                return number;
            } else {
                number = number*10 + parseInt(c);
            }
            
        }

        return number; //we can't get where

    }
}

function Task(filename)
{

    this.filename = filename;

    this.Task1 = function(min, max) {

        var fs = new ActiveXObject("Scripting.FileSystemObject");
        var file = fs.OpenTextFile(fs.GetParentFolderName(WScript.ScriptFullName) + '/' + this.filename, 2, true);

        for (var i = 1; i<=100; i++) {
            var n = min + Math.round(Math.random() * (max - min));
            file.Write(n.toString());
            file.Write(',');
        }
        
        file.Close();

    }

    this.Task2 = function(edge) {
 
        var fs = new ActiveXObject("Scripting.FileSystemObject");
        var file = fs.OpenTextFile(fs.GetParentFolderName(WScript.ScriptFullName) + '/' + this.filename, 1, false);

        var nextractor = new NumberExtractor(file.ReadLine(), ',');

        file.Close();

        var GreaterThanEdgeQty = 0;
        var result = "";

        while(!nextractor.isEmpty()) {

            var number = nextractor.getNext();
            
            if (number <= edge) {
                result += number.toString() + "\t0\n\r";
            } else {
                result += number.toString() + "\t1\n\r";
                GreaterThanEdgeQty += 1;
            }

        }

        WScript.Echo(result);
        WScript.Echo("Task2 number count: " + GreaterThanEdgeQty);

    }

    this.Task3 = function(n) {

        var n = 10;
    
        try {
            WScript.StdOut.WriteLine("Enter integer number from 1 to 10:");
            n = parseInt(WScript.StdIn.ReadLine());
        } catch (error) {
            
        }
        
        WScript.Echo(n.toString() + '! = ' + fact(n));
    }


}

task = new Task("numbers.csv");
task.Task1(1, 100);
task.Task2(50);
task.Task3();