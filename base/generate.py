from hashlib import sha256
from sys import argv
import csv
import glob
import os

"""
Use a hash function to generate a hex string for use in polymorphic code.
Ex: "test" -> 9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08
"""
def getHash(text):
    return sha256(str.encode(text)).hexdigest()

"""
Use a provided hash to generate a number between 0-max.
This method saves the offset as an attribute so it will remember
which characters from the hash were used.
"""
def polyInt(hashed, maximum):
    # chars_used is remembered between executions
    if not hasattr(polyInt, "offset"):
        polyInt.offset = 0

    # calculate how many characters from hash are needed
    chars_needed = 1
    while 16 ** chars_needed < (maximum + 1):
        chars_needed += 1

    # slice off a bit of the hash
    # ie use [9f] from 9f86d081884c7d659a2feaa0...
    start = polyInt.offset
    end = polyInt.offset + chars_needed
    n = int(hashed[start:end], 16) % maximum

    # increment offset so the same number isn't used each time
    polyInt.offset += chars_needed

    return n
    
"""
Use polyInt to generate a pseudorandom color skeme.
Uses the first 6 digits of the hash.
"""
def polyColors(hashed):
    palette = {}

    # generate color skeme format: (r, g, b)
    color = (format(polyInt(hashed, 15), "x"), format(polyInt(hashed, 15), "x"), format(polyInt(hashed, 15), "x"))
    bgcolor = (format(polyInt(hashed, 15), "x"), format(polyInt(hashed, 15), "x"), format(polyInt(hashed, 15), "x"))

    # use the primary colors to make a palette
    palette["fg1"] = f"#{color[0]}0{color[1]}0{color[2]}0"
    palette["fg2"] = f"#{color[0]}f{color[1]}f{color[2]}f"
    palette["bg1"] = f"#{bgcolor[0]}0{bgcolor[1]}0{bgcolor[2]}0"
    palette["bg2"] = f"#{bgcolor[0]}f{bgcolor[1]}f{bgcolor[2]}f"
    
    # print out the colors
    #print("Color Palette:")
    #for color in palette:
    #    print(f"{color}: {palette[color]}")
    
    return palette

"""
Read a CSV file into a keyed dictionary
"""
def readCSV(filename):
    data = {}
    header = []

    with open(filename, newline="") as csvfile:
        csvreader = csv.reader(csvfile)
        
        for row in csvreader:
            # use the first row as header
            if data == {}:
                header = row
                for col in row:
                    data[col] = []
                continue
            
            # add each item to the list in the proper header
            for col_num in range(len(row)):
                data[header[col_num]].append(row[col_num])
                #print(header[col_num], data[header[col_num]])
                
                
    #print(f"Successfuly read {filename}:", header)
    
    return data
   
"""
Generate a file and replace the polymorphic elements
"""
def polyFile(studentid, infile, outfile):
    # generate hash for use later
    hashed = getHash(studentid)
    #print(f"{studentid} -> {hashed}")
    
    # read the list of shops
    shops = readCSV("stores.csv")
    num_shops = len(shops["TITLE"])

    # open files to read / write
    fin = open(infile, "rt")
    fout = open(outfile, "wt")

    # pick a pseudorandom shop
    palette = polyColors(hashed)
    shop = polyInt(hashed, num_shops)

    # perform replacements & save
    for line in fin:
        line = line.replace("$TITLE", shops["TITLE"][shop])
        line = line.replace("$SLOGAN", shops["SLOGAN"][shop])
        line = line.replace("$COLOR1", palette["fg1"])
        line = line.replace("$COLOR2", palette["fg2"])
        line = line.replace("$BGCOLOR1", palette["bg1"])
        line = line.replace("$BGCOLOR2", palette["bg2"])
        line = line.replace("$HIDEME", "hidden")
        fout.write(line)

    # close files to read / write
    fin.close()
    fout.close()

if __name__ == "__main__":
    files = glob.glob("*.html") + ["default-style.css"]

    for i in range(10):
        # make a new folder for each lab
        try:
            os.mkdir(str(i))
        except:
            pass # file already exists

        # polymorph all of the .html files
        for filename in files:
            # reset polyInt so we generate save values
            polyInt.offset = 0
            polyFile(str(i), filename, f"{i}/{filename}")


