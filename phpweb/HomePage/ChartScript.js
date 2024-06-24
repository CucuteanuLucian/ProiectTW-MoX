document.addEventListener("DOMContentLoaded", function () {
    function createChart(chartId, chartType, dataUrl, labelName, datasetLabel) {
        fetch(dataUrl)
            .then(response => response.json())
            .then(data => {
                const labels = Object.keys(data);
                const counts = Object.values(data);
                let ctx = document.getElementById(chartId).getContext('2d');
                let chart = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: datasetLabel,
                            data: counts,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: {
                                        size: 14,
                                        color: 'white'
                                    },
                                    padding: 20
                                }
                            },
                            title: {
                                display: true,
                                font: {
                                    size: 20,
                                    color: 'white'
                                },
                                padding: {
                                    top: 10,
                                    bottom: 30
                                }
                            }
                        },
                        responsive: true
                    }
                });
            })
            .catch(error => console.error(`Error fetching ${labelName} data:`, error));
    }
    createChart('GenreChart', 'bar', 'GetGenres.php', 'genre', 'Shows In The Genre');
    createChart('RatingChart', 'pie', 'GetRatings.php', 'rating', 'Rating Count');
    createChart('YearChart', 'line', 'GetYears.php', 'year', 'Shows In The Year');
});

function exportAsWebP(chartId) {
    const canvas = document.getElementById(chartId);
    const dataURL = canvas.toDataURL('image/webp');
    const link = document.createElement('a');
    link.href = dataURL;
    link.download = chartId + '.webp';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Function to export the canvas as an SVG file
function exportAsSVG(chartId) {
    const canvas = document.getElementById(chartId);
    const width = canvas.width;
    const height = canvas.height;
    const xmlNs = "http://www.w3.org/2000/svg";
    // Create an SVG element with the same dimensions as the canvas
    const svg = document.createElementNS(xmlNs, "svg");
    svg.setAttributeNS(null, 'width', width);
    svg.setAttributeNS(null, 'height', height);
    // Convert the canvas to an image and use it in the SVG
    const img = new Image();
    img.src = canvas.toDataURL("image/png");
    const imgElement = document.createElementNS(xmlNs, "image");
    imgElement.setAttributeNS(null, 'width', width);
    imgElement.setAttributeNS(null, 'height', height);
    imgElement.setAttributeNS("http://www.w3.org/1999/xlink", 'href', img.src);
    svg.appendChild(imgElement);
    // Serialize the SVG to a string and return it
    const svgString = new XMLSerializer().serializeToString(svg);
    const blob = new Blob([svgString], { type: "image/svg+xml;charset=utf-8" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.setAttribute("hidden", "");
    a.setAttribute("href", url);
    a.setAttribute("download", chartId + '.svg');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

function exportAsCSV(dataUrl, labelName) {
    fetch(dataUrl)
        .then(response => response.json())
        .then(data => {
            const labels = Object.keys(data);
            const counts = Object.values(data);
            let csvContent = labelName + ",Count\n";
            for (let i = 0; i < labels.length; i++) {
                csvContent += labels[i] + ',' + counts[i] + '\n';
            }
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            // Create a link to download the Blob as a CSV file
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', labelName + '.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch(error => console.error(`Error fetching ${labelName} data:`, error));
}

