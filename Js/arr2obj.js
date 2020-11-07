export default function arr2obj (ar1 , ar2) {
    let keys = ar1;
    let values = ar2

    let result = {};
    keys.forEach((key, i) => result[key] = values[i]);
    return result;
    
}

