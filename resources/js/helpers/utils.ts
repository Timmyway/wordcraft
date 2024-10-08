import { nanoid } from 'nanoid';
import dayjs from 'dayjs';

function safeJsonParse(jsonString: string): any {
    if (typeof jsonString === 'string') {
        try {
            return JSON.parse(jsonString);
        } catch (e) {
            console.error('Error parsing JSON:', e);
            return {};
        }
    }
    return null;
}

function getNanoid() {
    return nanoid();
}

const imageToBase64 = (image: HTMLImageElement): Promise<string> => {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => {
            resolve(reader.result as string);
        };
        reader.onerror = (error) => {
            reject(error);
        };

        if (image.src.startsWith('blob:')) {
            fetch(image.src)
                .then(response => response.blob())
                .then(blob => reader.readAsDataURL(blob))
                .catch(reject);
        } else {
            const img = new Image();
            img.crossOrigin = 'Anonymous';
            img.src = image.src;
            img.onload = () => {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                if (ctx) {
                    ctx.drawImage(img, 0, 0);
                    resolve(canvas.toDataURL());
                } else {
                    reject(new Error('Could not get canvas context'));
                }
            };
            img.onerror = reject;
        }
    });
};

const base64ToImage = (base64: string): Promise<HTMLImageElement> => {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.onerror = (error) => reject(error);
        img.src = base64;
    });
};

// Helper function to load an image from a URL and return an HTMLImageElement
function loadImageFromURL(url: string): Promise<HTMLImageElement> {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.src = url;
        img.onload = () => resolve(img);
        img.onerror = (err) => reject(err);
    });
}

function pickRandomElement<T>(elements: T[]): T {
    const randomIndex = Math.floor(Math.random() * elements.length);
    return elements[randomIndex];
}

function truncateString(str: string, n: number = 50) {
    if (typeof str !== 'string') {
        throw new TypeError('Input must be a string');
    }
    if (typeof n !== 'number' || n < 0) {
        throw new TypeError('Parameter n must be a non-negative number');
    }
    if (str.length <= n) {
        return str;
    }
    return str.slice(0, n) + '...';
}

function toUserFriendlyDate(dateString: string,
    f = { datetime: 'D MMMM YYYY [à] HH:mm', date: 'D MMMM YYYY' }
) {
    if (!dateString) {
        return dateString;
    }

    // Check if the date string contains a time component
    const hasTime = dateString.includes('T');

    // Choose the format based on whether there is a time component
    const formatString = hasTime ? f.datetime : f.date;

    const formattedDate = dayjs(dateString).format(formatString);
    return formattedDate;
}

function truncateWord(str: string, maxLength = 15): string {
    if (typeof str !== 'string') {
        console.error('Input must be a string');
        return str;
    }
    if (typeof maxLength !== 'number' || maxLength <= 0) {
        console.error('maxLength must be a positive number');
        return str;
    }

    if (str.length > maxLength) {
        return str.substring(0, maxLength) + '...';
    } else {
        return str;
    }
}

function openGoogleSearch(keyword: string, searchType = 'image') {
    let url;

    if (searchType === 'image') {
        // Construct URL for Google Images search
        url = `https://www.google.com/search?tbm=isch&q=${encodeURIComponent(keyword)}`;
    } else if (searchType === 'web') {
        // Construct URL for regular Google search
        url = `https://www.google.com/search?q=${encodeURIComponent(keyword)}`;
    } else {
        // Handle other potential search types (if needed)
        console.warn('Unknown search type. Defaulting to web search.');
        url = `https://www.google.com/search?q=${encodeURIComponent(keyword)}`;
    }

    // Open the constructed URL in a new tab
    window.open(url, '_blank');
}

export { safeJsonParse, getNanoid, imageToBase64, base64ToImage, loadImageFromURL,
    pickRandomElement, nanoid, truncateString, toUserFriendlyDate, truncateWord,
    openGoogleSearch,
}
