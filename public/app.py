import fitz  # PyMuPDF
import pytesseract
from PIL import Image
import io
import sys
import json

# Configurar o caminho para o executável do Tesseract
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

def extract_text_from_image(image):
    text = pytesseract.image_to_string(image)
    return text

def search_in_pdf(filepath, search_string):
    results = []

    # Open the PDF file
    pdf_document = fitz.open(filepath)

    # Convert the search string to lowercase
    search_string = search_string.lower()

    for page_num in range(len(pdf_document)):
        page = pdf_document.load_page(page_num)

        # Check if page contains text or is an image
        text = page.get_text("text")
        if not text.strip():
            # If no text is found, perform OCR on the page image
            pix = page.get_pixmap()
            img = Image.open(io.BytesIO(pix.tobytes()))
            text = extract_text_from_image(img)

        lines = text.splitlines()

        for i, line in enumerate(lines):
            # Convert the line to lowercase
            if search_string in line.lower():
                # Concatenate lines to form a single string with a maximum of 255 characters
                following_text = ' '.join(lines[i+1:])
                if len(following_text) > 255:
                    following_text = following_text[:255] + '...'

                result = {
                    "page": page_num + 1,
                    "found_line": line,
                    "following_text": following_text
                }

                results.append(result)

    # Return results as JSON string
    output = {"results": results}

    # Print the JSON output only
    print(json.dumps(output))

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Usage: python app.py <PDF_FILE_PATH> <SEARCH_STRING>")
        sys.exit(1)

    pdf_file_path = sys.argv[1]
    search_string = sys.argv[2]

    print(f"Search string {search_string} in file {pdf_file_path}")

    search_in_pdf(pdf_file_path, search_string)
